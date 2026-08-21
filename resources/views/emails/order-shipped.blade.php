<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Shipped</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; margin: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #2196F3; padding-bottom: 20px; }
        .header h1 { color: #2196F3; margin: 0; }
        .status-badge { display: inline-block; padding: 5px 15px; background: #2196F3; color: #fff; border-radius: 20px; font-size: 14px; }
        .btn { display: inline-block; padding: 10px 25px; background: #2196F3; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #1976D2; }
        .footer { text-align: center; margin-top: 30px; color: #888; font-size: 14px; border-top: 1px solid #eee; padding-top: 20px; }
        .tracking-box { background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .item-list { background: #f5f5f5; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚚 Tech Nova</h1>
            <p style="font-size: 18px;">Your order is on its way!</p>
        </div>

        <h2>Dear {{ $order->user->name ?? 'Customer' }},</h2>
        <p>Your order <strong>#{{ $order->order_number ?? $order->id }}</strong> has been shipped! 🎉</p>

        <div class="tracking-box">
            <p><strong>Order Status:</strong> <span class="status-badge">{{ $order->status_label }}</span></p>
            <p><strong>Shipped Date:</strong> {{ $order->shipped_at ? $order->shipped_at->format('d M Y, h:i A') : 'N/A' }}</p>
            <p><strong>Estimated Delivery:</strong> 3-5 business days</p>
            <p><strong>Shipping Address:</strong> {{ $order->address->address ?? 'N/A' }}</p>
        </div>

        <div class="item-list">
            <h3>📦 Order Items</h3>
            @foreach($order->items as $item)
                <p>{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }} = Rs. {{ number_format($item->price * $item->quantity, 2) }}</p>
            @endforeach
            <p><strong>Grand Total:</strong> Rs. {{ number_format($order->grand_total, 2) }}</p>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('orders.track', $order->id) }}" class="btn">Track Your Order</a>
        </div>

        <div class="footer">
            <p>We hope you enjoy your purchase!</p>
            <p>© {{ date('Y') }} Tech Nova. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
