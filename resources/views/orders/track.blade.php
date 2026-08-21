<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order - Tech Nova</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; margin: 0; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #4CAF50; padding-bottom: 20px; }
        .header h1 { color: #4CAF50; margin: 0; }
        .timeline { display: flex; justify-content: space-between; margin: 40px 0; position: relative; }
        .timeline::before { content: ''; position: absolute; top: 40px; left: 10%; right: 10%; height: 3px; background: #ddd; z-index: 1; }
        .step { flex: 1; text-align: center; position: relative; z-index: 2; }
        .step .icon { font-size: 35px; background: #fff; padding: 5px 15px; border-radius: 50%; display: inline-block; }
        .step.active .icon { background: #4CAF50; color: #fff; border-radius: 50%; padding: 8px; }
        .step.completed .icon { background: #4CAF50; color: #fff; border-radius: 50%; padding: 8px; }
        .step .label { margin-top: 10px; font-weight: bold; font-size: 14px; }
        .step .date { font-size: 11px; color: #888; }
        .step.active .label { color: #4CAF50; }
        .step.completed .label { color: #4CAF50; }
        .order-info { background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .status-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-size: 14px; }
        .status-pending { background: #ffc107; color: #000; }
        .status-processing { background: #17a2b8; color: #fff; }
        .status-shipped { background: #007bff; color: #fff; }
        .status-delivered { background: #28a745; color: #fff; }
        .status-cancelled { background: #dc3545; color: #fff; }
        .btn { display: inline-block; padding: 10px 25px; background: #4CAF50; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #45a049; }
        .footer { text-align: center; margin-top: 30px; color: #888; font-size: 14px; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Tech Nova</h1>
            <p style="font-size: 18px;">Order Tracking</p>
        </div>

        <div class="order-info">
            <p><strong>Order ID:</strong> #{{ $order->order_number ?? $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
            <p><strong>Status:</strong>
                <span class="status-badge status-{{ $order->order_status }}">
                    {{ $order->status_label }}
                </span>
            </p>
            <p><strong>Grand Total:</strong> Rs. {{ number_format($order->grand_total, 2) }}</p>
        </div>

        <!-- Order Status Timeline -->
        <div class="timeline">
            <div class="step {{ $order->order_status == 'pending' ? 'active' : ($order->order_status != 'pending' ? 'completed' : '') }}">
                <div class="icon">📦</div>
                <div class="label">Order Placed</div>
                <div class="date">{{ $order->created_at->format('d M Y') }}</div>
            </div>
            <div class="step {{ $order->order_status == 'processing' ? 'active' : (in_array($order->order_status, ['shipped', 'delivered']) ? 'completed' : '') }}">
                <div class="icon">⚙️</div>
                <div class="label">Processing</div>
                <div class="date">{{ $order->updated_at->format('d M Y') }}</div>
            </div>
            <div class="step {{ $order->order_status == 'shipped' ? 'active' : ($order->order_status == 'delivered' ? 'completed' : '') }}">
                <div class="icon">🚚</div>
                <div class="label">Shipped</div>
                <div class="date">{{ $order->shipped_at ? $order->shipped_at->format('d M Y') : 'Pending' }}</div>
            </div>
            <div class="step {{ $order->order_status == 'delivered' ? 'active completed' : '' }}">
                <div class="icon">✅</div>
                <div class="label">Delivered</div>
                <div class="date">{{ $order->delivered_at ? $order->delivered_at->format('d M Y') : 'Pending' }}</div>
            </div>
        </div>

        <!-- Order Items -->
        <div style="background: #f5f5f5; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h3>📦 Order Items</h3>
            @foreach($order->items as $item)
                <p>{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }} = Rs. {{ number_format($item->price * $item->quantity, 2) }}</p>
            @endforeach
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/') }}" class="btn">Continue Shopping</a>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Tech Nova. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
