<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; margin: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #4CAF50; padding-bottom: 20px; }
        .header h1 { color: #4CAF50; margin: 0; }
        .header p { font-size: 18px; color: #555; }
        .order-details { margin: 20px 0; padding: 20px; background: #f9f9f9; border-radius: 8px; }
        .order-item { padding: 10px 0; border-bottom: 1px solid #eee; }
        .order-item:last-child { border-bottom: none; }
        .total { font-size: 18px; font-weight: bold; color: #4CAF50; text-align: right; margin-top: 20px; }
        .status-badge { display: inline-block; padding: 5px 15px; background: #4CAF50; color: #fff; border-radius: 20px; font-size: 14px; }
        .footer { text-align: center; margin-top: 30px; color: #888; font-size: 14px; border-top: 1px solid #eee; padding-top: 20px; }
        .btn { display: inline-block; padding: 10px 25px; background: #4CAF50; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #45a049; }
        .tracking-box { background: #e8f5e9; padding: 15px; border-radius: 8px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Tech Nova</h1>
            <p>Thank you for your purchase!</p>
        </div>

        <h2>Dear {{ $order->user->name ?? 'Customer' }},</h2>
        <p>Your order has been successfully placed. Here are the details:</p>

        <div class="order-details">
            <p><strong>Order ID:</strong> #{{ $order->order_number ?? $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
            <p><strong>Shipping Address:</strong> {{ $order->address->address ?? 'N/A' }}</p>
            <p><strong>Order Status:</strong> <span class="status-badge">{{ $order->status_label }}</span></p>

            <h3>Order Items:</h3>
            @foreach($order->items as $item)
                <div class="order-item">
                    <strong>{{ $item->product->name ?? 'Product' }}</strong>
                    <br>Quantity: {{ $item->quantity }}
                    <br>Price: Rs. {{ number_format($item->price, 2) }}
                    @if($item->variant)
                        <br><small>Variant: {{ $item->variant->full_name ?? 'Standard' }}</small>
                    @endif
                </div>
            @endforeach

            <div style="margin-top: 15px;">
                <p><strong>Subtotal:</strong> Rs. {{ number_format($order->subtotal, 2) }}</p>
                @if($order->discount > 0)
                    <p><strong>Discount:</strong> -Rs. {{ number_format($order->discount, 2) }}</p>
                @endif
                <p><strong>Delivery Charge:</strong> Rs. {{ number_format($order->delivery_charge, 2) }}</p>
                <p><strong>Tax:</strong> Rs. {{ number_format($order->tax, 2) }}</p>
                <div class="total">
                    Grand Total: Rs. {{ number_format($order->grand_total, 2) }}
                </div>
            </div>
        </div>

        <div class="tracking-box" style="text-align: center;">
            <p>📦 You can track your order status anytime.</p>
            <a href="{{ route('orders.track', $order->id) }}" class="btn">Track Your Order</a>
        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} Tech Nova. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
