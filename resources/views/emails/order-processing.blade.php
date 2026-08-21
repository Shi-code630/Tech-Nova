<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Processing</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; margin: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #FF9800; padding-bottom: 20px; }
        .header h1 { color: #FF9800; margin: 0; }
        .status-badge { display: inline-block; padding: 5px 15px; background: #FF9800; color: #fff; border-radius: 20px; font-size: 14px; }
        .btn { display: inline-block; padding: 10px 25px; background: #FF9800; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #e68900; }
        .footer { text-align: center; margin-top: 30px; color: #888; font-size: 14px; border-top: 1px solid #eee; padding-top: 20px; }
        .info-box { background: #fff3e0; padding: 20px; border-radius: 8px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Tech Nova</h1>
            <p style="font-size: 18px;">Your order is being processed</p>
        </div>

        <h2>Dear {{ $order->user->name ?? 'Customer' }},</h2>
        <p>Great news! We are now processing your order <strong>#{{ $order->order_number ?? $order->id }}</strong>.</p>

        <div class="info-box">
            <p><strong>Order Status:</strong> <span class="status-badge">{{ $order->status_label }}</span></p>
            <p><strong>Order ID:</strong> #{{ $order->order_number ?? $order->id }}</p>
            <p><strong>Estimated Processing Time:</strong> 1-2 business days</p>
            <p><strong>Grand Total:</strong> Rs. {{ number_format($order->grand_total, 2) }}</p>
        </div>

        <div style="padding: 15px; background: #e3f2fd; border-radius: 8px; margin: 20px 0;">
            <h3>📦 Order Summary</h3>
            @foreach($order->items as $item)
                <p>{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }} = Rs. {{ number_format($item->price * $item->quantity, 2) }}</p>
            @endforeach
            <p><strong>Total:</strong> Rs. {{ number_format($order->grand_total, 2) }}</p>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('orders.track', $order->id) }}" class="btn">Track Your Order</a>
        </div>

        <div class="footer">
            <p>We will notify you once your order is shipped.</p>
            <p>© {{ date('Y') }} Tech Nova. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
