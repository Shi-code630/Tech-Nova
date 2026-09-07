<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Confirmation</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #eef4ff;
    font-family: Arial, Helvetica, sans-serif;
    color: #1f2937;
">

    <div style="
        width: 100%;
        padding: 40px 15px;
        box-sizing: border-box;
    ">

        <div style="
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        ">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div style="
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                padding: 35px 25px;
                text-align: center;
                color: #ffffff;
            ">

                <div style="
                    width: 65px;
                    height: 65px;
                    line-height: 65px;
                    margin: 0 auto 15px;
                    background: rgba(255,255,255,0.18);
                    border-radius: 50%;
                    font-size: 30px;
                ">
                    ✓
                </div>

                <h1 style="
                    margin: 0;
                    font-size: 26px;
                    font-weight: 700;
                ">
                    Tech Nova
                </h1>

                <p style="
                    margin: 9px 0 0;
                    font-size: 15px;
                    color: #dbeafe;
                ">
                    Order Confirmed Successfully
                </p>

            </div>


            {{-- =====================================================
                CONTENT
            ====================================================== --}}
            <div style="
                padding: 30px 25px;
            ">

                {{-- Greeting --}}
                <h2 style="
                    margin: 0 0 10px;
                    font-size: 21px;
                    color: #111827;
                ">
                    Dear {{ $order->user->name ?? 'Customer' }},
                </h2>

                <p style="
                    margin: 0 0 25px;
                    font-size: 15px;
                    line-height: 1.7;
                    color: #6b7280;
                ">
                    Thank you for shopping with
                    <strong style="color: #2563eb;">
                        Tech Nova
                    </strong>.
                    Your order has been successfully placed.
                    Here are your order details:
                </p>


                {{-- =================================================
                    ORDER INFORMATION
                ================================================== --}}
                <div style="
                    border: 1px solid #dbeafe;
                    border-radius: 12px;
                    overflow: hidden;
                    margin-bottom: 25px;
                ">

                    {{-- Order ID --}}
                    <div style="
                        padding: 16px 18px;
                        background: #f8fbff;
                        border-bottom: 1px solid #e5e7eb;
                    ">

                        <div style="
                            font-size: 12px;
                            color: #6b7280;
                            margin-bottom: 5px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        ">
                            Order ID
                        </div>

                        <div style="
                            font-size: 16px;
                            font-weight: 700;
                            color: #2563eb;
                        ">
                            #{{ $order->order_number ?? $order->id }}
                        </div>

                    </div>


                    {{-- Order Date --}}
                    <div style="
                        padding: 16px 18px;
                        border-bottom: 1px solid #e5e7eb;
                    ">

                        <div style="
                            font-size: 12px;
                            color: #6b7280;
                            margin-bottom: 5px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        ">
                            Order Date
                        </div>

                        <div style="
                            font-size: 15px;
                            font-weight: 600;
                            color: #111827;
                        ">
                            {{ $order->created_at->format('d M Y, h:i A') }}
                        </div>

                    </div>


                    {{-- Payment Method --}}
                    <div style="
                        padding: 16px 18px;
                        border-bottom: 1px solid #e5e7eb;
                    ">

                        <div style="
                            font-size: 12px;
                            color: #6b7280;
                            margin-bottom: 5px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        ">
                            Payment Method
                        </div>

                        <div style="
                            font-size: 15px;
                            font-weight: 600;
                            color: #111827;
                        ">
                            {{ $order->payment_method ?? 'N/A' }}
                        </div>

                    </div>


                    {{-- Payment Status --}}
                    <div style="
                        padding: 16px 18px;
                        border-bottom: 1px solid #e5e7eb;
                    ">

                        <div style="
                            font-size: 12px;
                            color: #6b7280;
                            margin-bottom: 7px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        ">
                            Payment Status
                        </div>

                        <span style="
                            display: inline-block;
                            background: #dcfce7;
                            color: #15803d;
                            padding: 6px 13px;
                            border-radius: 20px;
                            font-size: 12px;
                            font-weight: 700;
                        ">
                            {{ ucfirst($order->payment_status) }}
                        </span>

                    </div>


                    {{-- Order Status --}}
                    <div style="
                        padding: 16px 18px;
                        border-bottom: 1px solid #e5e7eb;
                    ">

                        <div style="
                            font-size: 12px;
                            color: #6b7280;
                            margin-bottom: 7px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        ">
                            Order Status
                        </div>

                        <span style="
                            display: inline-block;
                            background: #dbeafe;
                            color: #1d4ed8;
                            padding: 6px 13px;
                            border-radius: 20px;
                            font-size: 12px;
                            font-weight: 700;
                        ">
                            {{ $order->status_label }}
                        </span>

                    </div>


                    {{-- Shipping Address --}}
                    <div style="
                        padding: 16px 18px;
                    ">

                        <div style="
                            font-size: 12px;
                            color: #6b7280;
                            margin-bottom: 5px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        ">
                            Shipping Address
                        </div>

                        <div style="
                            font-size: 14px;
                            line-height: 1.6;
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $order->address->address ?? 'N/A' }}
                        </div>

                    </div>

                </div>


                {{-- =================================================
                    ORDER ITEMS
                ================================================== --}}
                <div style="
                    margin-bottom: 25px;
                ">

                    <h3 style="
                        margin: 0 0 12px;
                        font-size: 17px;
                        color: #111827;
                    ">
                        📦 Order Items
                    </h3>


                    <div style="
                        background: #f8fafc;
                        border: 1px solid #e2e8f0;
                        border-radius: 12px;
                        padding: 5px 18px;
                    ">

                        @foreach ($order->items as $item)

                            <div style="
                                padding: 15px 0;
                                border-bottom: 1px solid #e5e7eb;
                            ">

                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>

                                        <td style="
                                            width: 65%;
                                            vertical-align: top;
                                            padding-right: 10px;
                                        ">

                                            <div style="
                                                font-size: 14px;
                                                font-weight: 700;
                                                color: #111827;
                                                line-height: 1.5;
                                            ">
                                                {{ $item->product->name ?? 'Product' }}
                                            </div>

                                            @if ($item->variant)

                                                <div style="
                                                    margin-top: 5px;
                                                    font-size: 12px;
                                                    color: #6b7280;
                                                ">
                                                    Variant:
                                                    {{ $item->variant->full_name ?? 'Standard' }}
                                                </div>

                                            @endif

                                        </td>


                                        <td style="
                                            width: 35%;
                                            text-align: right;
                                            vertical-align: top;
                                        ">

                                            <div style="
                                                font-size: 14px;
                                                font-weight: 700;
                                                color: #2563eb;
                                            ">
                                                Rs. {{ number_format($item->price, 2) }}
                                            </div>

                                            <div style="
                                                margin-top: 5px;
                                                font-size: 12px;
                                                color: #6b7280;
                                            ">
                                                Qty: {{ $item->quantity }}
                                            </div>

                                        </td>

                                    </tr>
                                </table>

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- =================================================
                    PRICE SUMMARY
                ================================================== --}}
                <div style="
                    background: #f8fbff;
                    border: 1px solid #dbeafe;
                    border-radius: 12px;
                    padding: 20px;
                    margin-bottom: 25px;
                ">

                    <h3 style="
                        margin: 0 0 15px;
                        font-size: 17px;
                        color: #111827;
                    ">
                        💰 Order Summary
                    </h3>


                    {{-- Subtotal --}}
                    <div style="
                        padding: 7px 0;
                    ">

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="
                                    font-size: 14px;
                                    color: #6b7280;
                                ">
                                    Subtotal
                                </td>

                                <td style="
                                    text-align: right;
                                    font-size: 14px;
                                    color: #374151;
                                    font-weight: 600;
                                ">
                                    Rs. {{ number_format($order->subtotal, 2) }}
                                </td>
                            </tr>
                        </table>

                    </div>


                    {{-- Discount --}}
                    @if ($order->discount > 0)

                        <div style="
                            padding: 7px 0;
                        ">

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="
                                        font-size: 14px;
                                        color: #16a34a;
                                    ">
                                        Discount
                                    </td>

                                    <td style="
                                        text-align: right;
                                        font-size: 14px;
                                        color: #16a34a;
                                        font-weight: 600;
                                    ">
                                        -Rs. {{ number_format($order->discount, 2) }}
                                    </td>
                                </tr>
                            </table>

                        </div>

                    @endif


                    {{-- Delivery --}}
                    <div style="
                        padding: 7px 0;
                    ">

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="
                                    font-size: 14px;
                                    color: #6b7280;
                                ">
                                    Delivery Charge
                                </td>

                                <td style="
                                    text-align: right;
                                    font-size: 14px;
                                    color: #374151;
                                    font-weight: 600;
                                ">
                                    Rs. {{ number_format($order->delivery_charge, 2) }}
                                </td>
                            </tr>
                        </table>

                    </div>


                    {{-- Tax --}}
                    <div style="
                        padding: 7px 0 15px;
                    ">

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="
                                    font-size: 14px;
                                    color: #6b7280;
                                ">
                                    Tax
                                </td>

                                <td style="
                                    text-align: right;
                                    font-size: 14px;
                                    color: #374151;
                                    font-weight: 600;
                                ">
                                    Rs. {{ number_format($order->tax, 2) }}
                                </td>
                            </tr>
                        </table>

                    </div>


                    {{-- Grand Total --}}
                    <div style="
                        border-top: 1px solid #dbeafe;
                        padding-top: 15px;
                    ">

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>

                                <td style="
                                    font-size: 17px;
                                    font-weight: 700;
                                    color: #111827;
                                ">
                                    Grand Total
                                </td>

                                <td style="
                                    text-align: right;
                                    font-size: 21px;
                                    font-weight: 800;
                                    color: #2563eb;
                                ">
                                    Rs. {{ number_format($order->grand_total, 2) }}
                                </td>

                            </tr>
                        </table>

                    </div>

                </div>


                {{-- =================================================
                    TRACKING BOX
                ================================================== --}}
                <div style="
                    background: #eff6ff;
                    border: 1px solid #bfdbfe;
                    border-radius: 12px;
                    padding: 22px;
                    text-align: center;
                    margin-bottom: 10px;
                ">

                    <div style="
                        font-size: 26px;
                        margin-bottom: 8px;
                    ">
                        📦
                    </div>

                    <h3 style="
                        margin: 0 0 7px;
                        font-size: 17px;
                        color: #1e3a8a;
                    ">
                        Track Your Order
                    </h3>

                    <p style="
                        margin: 0 0 18px;
                        font-size: 13px;
                        line-height: 1.6;
                        color: #64748b;
                    ">
                        You can check your order status and delivery
                        updates anytime.
                    </p>

                    <a href="{{ route('orders.track', $order->id) }}"
                        style="
                            display: inline-block;
                            background: #2563eb;
                            color: #ffffff;
                            text-decoration: none;
                            padding: 12px 28px;
                            border-radius: 8px;
                            font-size: 14px;
                            font-weight: 700;
                        ">
                        Track Your Order
                    </a>

                </div>

            </div>


            {{-- =====================================================
                FOOTER
            ====================================================== --}}
            <div style="
                background: #f8fafc;
                border-top: 1px solid #e5e7eb;
                padding: 25px 20px;
                text-align: center;
            ">

                <div style="
                    font-size: 19px;
                    font-weight: 800;
                    color: #2563eb;
                    margin-bottom: 8px;
                ">
                    Tech Nova
                </div>

                <p style="
                    margin: 0 0 6px;
                    font-size: 13px;
                    color: #6b7280;
                ">
                    Thank you for shopping with us!
                </p>

                <p style="
                    margin: 0 0 6px;
                    font-size: 12px;
                    color: #9ca3af;
                ">
                    This is an automated email. Please do not reply
                    to this email.
                </p>

                <p style="
                    margin: 0;
                    font-size: 12px;
                    color: #9ca3af;
                ">
                    © {{ date('Y') }} Tech Nova. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</body>

</html>
