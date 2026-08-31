<?php

namespace App\Observers;

use App\Mail\OrderCancelledMail;
use App\Mail\OrderConfirmationMail;
use App\Mail\OrderDeliveredMail;
use App\Mail\OrderProcessingMail;
use App\Mail\OrderShippedMail;
use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Support\Facades\Mail;


class OrderObserver
{
    public function created(Order $order): void
    {
        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $order->order_status,
            'location' => $order->current_location ?? 'Order received at warehouse',
            'note' => 'Order placed successfully',
            'tracked_at' => now(),
        ]);

        if ($order->user?->email) {
            Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
        }
    }

    public function updating(Order $order): void
    {
        if (! $order->isDirty('order_status')) {
            return;
        }

        if ($order->order_status === 'shipped' && ! $order->shipped_at) {
            $order->shipped_at = now();
        }

        if ($order->order_status === 'delivered' && ! $order->delivered_at) {
            $order->delivered_at = now();
        }
    }

    public function updated(Order $order): void
    {

        if ($order->wasChanged('order_status')) {
            $newStatus = $order->order_status;

            OrderTracking::create([
                'order_id' => $order->id,
                'status' => $newStatus,
                'location' => $order->current_location ?? 'In transit',
                'note' => 'Status updated to ' . ucfirst($newStatus),
                'tracked_at' => now(),
            ]);


            if ($order->user?->email) {
                match ($newStatus) {
                    'processing' => Mail::to($order->user->email)->send(new OrderProcessingMail($order)),
                    'shipped' => Mail::to($order->user->email)->send(new OrderShippedMail($order)),
                    'delivered' => Mail::to($order->user->email)->send(new OrderDeliveredMail($order)),
                    'cancelled' => Mail::to($order->user->email)->send(new OrderCancelledMail($order)),
                    default => null,
                };
            }
        }
    }
}
