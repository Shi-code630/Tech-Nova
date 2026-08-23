<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Delivered</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; margin: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #4CAF50; padding-bottom: 20px; }
        .header h1 { color: #4CAF50; margin: 0; }
        .status-badge { display: inline-block; padding: 5px 15px; background: #4CAF50; color: #fff; border-radius: 20px; font-size: 14px; }
        .btn { display: inline-block; padding: 10px 25px; background: #4CAF50; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #45a049; }
        .footer { text-align: center; margin-top: 30px; color: #888; font-size: 14px; border-top: 1px solid #eee; padding-top: 20px; }
        .review-box { background: #f1f8e9; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
        .item-summary { background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Tech Nova</h1>
            <p style="font-size: 18px;">Your order has been delivered!</p>
        </div>

        <h2>Dear {{ $order->user->name ?? 'Customer' }},</h2>
        <p>Your order <strong>#{{ $order->order_number ?? $order->id }}</strong> has been successfully delivered! 🎊</p>

        <div class="review-box">
            <p><strong>Order Status:</strong> <span class="status-badge">{{ $order->status_label }}</span></p>
            <p><strong>Delivered Date:</strong> {{ $order->delivered_at ? $order->delivered_at->format('d M Y, h:i A') : 'N/A' }}</p>
            <p><strong>Grand Total:</strong> Rs. {{ number_format($order->grand_total, 2) }}</p>
        </div>

        <div class="item-summary">
            <h3>📦 Order Items</h3>
            @foreach($order->items as $item)
                <p>{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }}</p>
            @endforeach
        </div>

        <div style="text-align: center; padding: 20px 0;">
            <h3>🌟 Loved our service?</h3>
            <p>Please take a moment to <strong>rate your experience</strong> with us.</p>
            <a href="{{ route('orders.review', $order->id) }}" class="btn">Write a Review</a>
        </div>

        <div class="footer">
            <p>Thank you for shopping with Tech Nova!</p>
            <p>Visit again for amazing deals 🛍️</p>
            <p>© {{ date('Y') }} Tech Nova. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
