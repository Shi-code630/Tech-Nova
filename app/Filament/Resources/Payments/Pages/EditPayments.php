<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPayments extends EditRecord
{
    protected static string $resource = PaymentsResource::class;

    protected function afterSave(): void
    {
        $payment = $this->record;

        if (!$payment->order) {
            return;
        }

        $orderPaymentStatus = match ($payment->status) {
            'completed' => 'paid',
            'failed' => 'failed',
            'pending' => 'pending',
            'refunded' => 'refunded',
            default => 'pending',
        };

        $payment->order->update([
            'payment_status' => $orderPaymentStatus,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
