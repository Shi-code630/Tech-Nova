<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Mail\OrderProcessingMail;
use App\Mail\OrderShippedMail;
use App\Mail\OrderDeliveredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderStatusEmail implements ShouldQueue
{
    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order;
        $newStatus = $event->newStatus;

        // Status अनुसार different email send गर्ने
        $mailClass = match ($newStatus) {
            'processing' => new OrderProcessingMail($order),
            'shipped' => new OrderShippedMail($order),
            'delivered' => new OrderDeliveredMail($order),
            default => null,
        };

        if ($mailClass && $order->user && $order->user->email) {
            Mail::to($order->user->email)->send($mailClass);
        }
    }
}
