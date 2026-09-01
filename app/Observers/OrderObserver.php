<?php

namespace App\Observers;

use App\Mail\OrderCancelledMail;
use App\Mail\OrderConfirmationMail;
use App\Mail\OrderDeliveredMail;
use App\Mail\OrderProcessingMail;
use App\Mail\OrderShippedMail;
use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    protected string $companyEmail = 'technova2083@gmail.com';

    public function created(Order $order): void
    {
        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $order->order_status,
            'location' => $order->current_location ?? 'Order received at warehouse',
            'note' => 'Order placed successfully',
            'tracked_at' => now(),
        ]);

        $this->sendOrderEmail(
            $order,
            new OrderConfirmationMail($order),
            ccCompany: true
        );
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
        if (! $order->wasChanged('order_status')) {
            return;
        }

        $newStatus = $order->order_status;

        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $newStatus,
            'location' => $order->current_location ?? 'In transit',
            'note' => 'Status updated to ' . ucfirst($newStatus),
            'tracked_at' => now(),
        ]);

        $mailable = match ($newStatus) {
            'processing' => new OrderProcessingMail($order),
            'shipped' => new OrderShippedMail($order),
            'delivered' => new OrderDeliveredMail($order),
            'cancelled' => new OrderCancelledMail($order),
            default => null,
        };

        if ($mailable) {
            $this->sendOrderEmail($order, $mailable);
        }
    }

    /**
     * Send an order-related email safely, without letting a mail
     * failure break the calling flow (order creation/update).
     */
    protected function sendOrderEmail(Order $order, $mailable, bool $ccCompany = false): void
    {
        if (! $order->user?->email) {
            return;
        }

        try {
            $mail = Mail::to($order->user->email);

            if ($ccCompany) {
                $mail->cc($this->companyEmail);
            }

            $mail->send($mailable);
        } catch (\Exception $e) {
            Log::error('Order email failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'mailable' => get_class($mailable),
            ]);
        }
    }
}
