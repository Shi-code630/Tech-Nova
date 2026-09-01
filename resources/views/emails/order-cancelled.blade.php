<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; margin: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #f44336; padding-bottom: 20px; }
        .header h1 { color: #f44336; margin: 0; }
        .status-badge { display: inline-block; padding: 5px 15px; background: #f44336; color: #fff; border-radius: 20px; font-size: 14px; }
        .btn { display: inline-block; padding: 10px 25px; background: #f44336; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #d32f2f; }
        .footer { text-align: center; margin-top: 30px; color: #888; font-size: 14px; border-top: 1px solid #eee; padding-top: 20px; }
        .info-box { background: #ffebee; padding: 20px; border-radius: 8px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❌ Tech Nova</h1>
            <p style="font-size: 18px;">Your order has been cancelled</p>
        </div>

        <h2>Dear {{ $order->user->name ?? 'Customer' }},</h2>
        <p>Your order <strong>#{{ $order->order_number ?? $order->id }}</strong> has been cancelled.</p>

        <div class="info-box">
            <p><strong>Order Status:</strong> <span class="status-badge">{{ $order->status_label }}</span></p>
            <p><strong>Order ID:</strong> #{{ $order->order_number ?? $order->id }}</p>
            <p><strong>Grand Total:</strong> Rs. {{ number_format($order->grand_total, 2) }}</p>
        </div>

        <div style="padding: 15px; background: #e3f2fd; border-radius: 8px; margin: 20px 0;">
            <h3>📦 Order Items</h3>
            @foreach($order->items as $item)
                <p>{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }}</p>
            @endforeach
        </div>

        <p>If you have any questions, please contact our support team.</p>

        <div class="footer">
            <p>© {{ date('Y') }} Tech Nova. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
