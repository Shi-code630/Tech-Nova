<?php

namespace App\Observers;

use App\Mail\OrderCancelledMail;
use App\Mail\OrderConfirmationMail;
use App\Mail\OrderDeliveredMail;
use App\Mail\OrderProcessingMail;
use App\Mail\OrderShippedMail;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Helpers\RewardHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderObserver
{
    protected string $companyEmail = 'technova2083@gmail.com';

    public function created(Order $order): void
    {
        $location = $this->getOrderLocation($order);

        $this->createTracking($order, $location, 'Order placed successfully');

        $this->updateOrderWithTracking($order, $location);

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
        $location = $this->getOrderLocation($order);

        if ($order->wasChanged('order_status')) {
            $this->handleStatusChange($order, $location);
        }

        if ($order->isDirty('tracking_number') && $order->tracking_number) {
            $this->handleTrackingAssignment($order, $location);
        }

        if ($order->wasChanged('order_status') &&
            $order->order_status === 'delivered' &&
            !$order->points_given) {
            $this->handleCoinsEarning($order);
        }
    }

    public function deleted(Order $order): void
    {
        try {
            $order->trackings()->delete();
            Log::info("🗑️ Tracking records deleted for order: {$order->order_number}");
        } catch (\Exception $e) {
            Log::error('❌ Tracking delete failed: ' . $e->getMessage());
        }
    }

    private function createTracking(Order $order, string $location, string $note): void
    {
        try {
            $trackingNumber = 'TRK-' . strtoupper(Str::random(10));

            OrderTracking::create([
                'order_id' => $order->id,
                'tracking_number' => $trackingNumber,
                'courier_name' => 'Tech Nova Logistics',
                'status' => $order->order_status ?? 'pending',
                'location' => $location,
                'note' => $note,
                'status_date' => now(),
            ]);

            Log::info("✅ Tracking created for order: {$order->order_number} - {$trackingNumber}");

        } catch (\Exception $e) {
            Log::error('❌ Order tracking creation failed: ' . $e->getMessage());
        }
    }

    private function updateOrderWithTracking(Order $order, string $location): void
    {
        try {
            $trackingNumber = 'TRK-' . strtoupper(Str::random(10));

            $order->updateQuietly([
                'tracking_number' => $trackingNumber,
                'courier_name' => 'Tech Nova Logistics',
                'current_location' => $location,
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Order update failed: ' . $e->getMessage());
        }
    }

    private function handleStatusChange(Order $order, string $location): void
    {
        $oldStatus = $order->getOriginal('order_status');
        $newStatus = $order->order_status;

        $this->createTracking(
            $order,
            $location,
            "Status updated: {$oldStatus} → {$newStatus}"
        );

        Log::info("📦 Order status updated: {$oldStatus} → {$newStatus}");

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

    private function handleTrackingAssignment(Order $order, string $location): void
    {
        try {
            OrderTracking::create([
                'order_id' => $order->id,
                'tracking_number' => $order->tracking_number,
                'courier_name' => $order->courier_name ?? 'Tech Nova Logistics',
                'status' => $order->order_status ?? 'processing',
                'location' => $location,
                'note' => "Tracking number: {$order->tracking_number}",
                'status_date' => now(),
            ]);

            Log::info("🔢 Tracking number assigned: {$order->tracking_number}");

        } catch (\Exception $e) {
            Log::error('❌ Tracking number assignment failed: ' . $e->getMessage());
        }
    }

    private function handleCoinsEarning(Order $order): void
    {
        $user = $order->user;

        if (!$user) {
            return;
        }

        $points = RewardHelper::calculateEarnedCoins($order->grand_total);

        if ($points <= 0) {
            return;
        }

        try {
            $user->addCoins(
                $points,
                $order->id,
                "Earned {$points} coins from order #{$order->order_number}"
            );

            $order->updateQuietly([
                'points_earned' => $points,
                'points_given' => true,
            ]);

            Log::info("🪙 Coins earned: {$points} for order {$order->order_number}");

        } catch (\Exception $e) {
            Log::error('❌ Coin earning failed: ' . $e->getMessage());
        }
    }

    private function getOrderLocation(Order $order): string
    {
        if ($order->address) {
            $address = $order->address;
            $location = trim($address->city ?? '') . ', ' . trim($address->district ?? '');

            if (!empty($location) && $location !== ', ') {
                return $location;
            }

            return $address->address ?? $address->city ?? $address->district ?? 'Order Received';
        }

        return $order->current_location ?? 'Order Received';
    }

    private function sendOrderEmail(Order $order, $mailable, bool $ccCompany = false): void
    {
        if (!$order->user?->email) {
            return;
        }

        try {
            $mail = Mail::to($order->user->email);

            if ($ccCompany) {
                $mail->cc($this->companyEmail);
            }

            $mail->send($mailable);

            Log::info("📧 Email sent for order: {$order->order_number}");

        } catch (\Exception $e) {
            Log::error('❌ Order email failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'mailable' => get_class($mailable),
            ]);
        }
    }
}
