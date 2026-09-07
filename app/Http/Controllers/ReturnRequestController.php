<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReturnRequestRequest;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\ReturnRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnRequestController extends Controller
{
    public function create(Request $request, Order $order): View
    {
        $order = $request->user()
            ->orders()
            ->with(['items.product.variants', 'items.variant'])
            ->findOrFail($order->id);

        $this->ensureOrderIsEligible($order);

        return view('user.return-requests.create', [
            'order' => $order,
        ]);
    }

    public function store(
        StoreReturnRequestRequest $request,
        Order $order
    ): RedirectResponse {
        $order = $request->user()
            ->orders()
            ->findOrFail($order->id);

        $this->ensureOrderIsEligible($order);

        $validated = $request->validated();

        $orderItem = $order->items()
            ->whereKey($validated['order_item_id'])
            ->firstOrFail();

        $alreadyRequestedQuantity = $orderItem->returnRequests()
            ->where('status', '!=', ReturnRequest::STATUS_REJECTED)
            ->sum('quantity');

        $availableQuantity = $orderItem->quantity - $alreadyRequestedQuantity;

        if ($validated['quantity'] > $availableQuantity) {
            return back()
                ->withInput()
                ->withErrors([
                    'quantity' => "Only {$availableQuantity} item(s) are eligible for return or exchange.",
                ]);
        }

        if ($validated['request_type'] === ReturnRequest::TYPE_EXCHANGE) {
            $exchangeVariant = ProductVariant::query()
                ->active()
                ->inStock()
                ->whereKey($validated['exchange_variant_id'])
                ->where('product_id', $orderItem->product_id)
                ->where('stock', '>=', $validated['quantity'])
                ->first();

            if (! $exchangeVariant) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'exchange_variant_id' => 'Select an available variant of the ordered product.',
                    ]);
            }
        }

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('return-requests', 'public')
            : null;

        ReturnRequest::create([
            'order_id' => $order->id,
            'order_item_id' => $orderItem->id,
            'user_id' => $request->user()->id,
            'request_type' => $validated['request_type'],
            'exchange_variant_id' => $validated['exchange_variant_id'] ?? null,
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('user.order.view', $order)
            ->with('success', 'Your return or exchange request has been submitted.');
    }

    private function ensureOrderIsEligible(Order $order): void
    {
        abort_unless(
            $order->order_status === Order::STATUS_DELIVERED
                && $order->delivered_at !== null
                && now()->lte($order->delivered_at->copy()->addDays(7)),
            403,
            'Return or exchange requests are allowed only within 7 days of delivery.'
        );
    }
}
