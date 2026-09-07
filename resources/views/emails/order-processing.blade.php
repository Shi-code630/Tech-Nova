<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Processing</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #fff7ed;
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
                background: linear-gradient(135deg, #f59e0b, #ea580c);
                padding: 35px 25px;
                text-align: center;
                color: #ffffff;
            ">

                {{-- Processing Icon --}}
                <div style="
                    width: 65px;
                    height: 65px;
                    line-height: 65px;
                    margin: 0 auto 15px;
                    background: rgba(255,255,255,0.18);
                    border-radius: 50%;
                    font-size: 30px;
                ">
                    ↻
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
                    color: #ffedd5;
                ">
                    Your Order Is Being Processed
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
                    Great news! 🎉 We have started processing your order
                    <strong style="color: #111827;">
                        #{{ $order->order_number ?? $order->id }}
                    </strong>.
                    Our team is preparing your items for the next step.
                </p>


                {{-- =================================================
                    PROCESSING SUMMARY
                ================================================== --}}
                <div style="
                    border: 1px solid #fed7aa;
                    border-radius: 12px;
                    overflow: hidden;
                    margin-bottom: 25px;
                ">

                    {{-- Order Status --}}
                    <div style="
                        padding: 17px 18px;
                        background: #fff7ed;
                        border-bottom: 1px solid #ffedd5;
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
                            background: #f59e0b;
                            color: #ffffff;
                            padding: 6px 15px;
                            border-radius: 20px;
                            font-size: 12px;
                            font-weight: 700;
                        ">
                            {{ $order->status_label }}
                        </span>

                    </div>


                    {{-- Order ID --}}
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
                            Order ID
                        </div>

                        <div style="
                            font-size: 16px;
                            font-weight: 700;
                            color: #ea580c;
                        ">
                            #{{ $order->order_number ?? $order->id }}
                        </div>

                    </div>


                    {{-- Processing Time --}}
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
                            Estimated Processing Time
                        </div>

                        <div style="
                            font-size: 15px;
                            font-weight: 600;
                            color: #111827;
                        ">
                            1–2 Business Days
                        </div>

                    </div>


                    {{-- Grand Total --}}
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
                            Grand Total
                        </div>

                        <div style="
                            font-size: 20px;
                            font-weight: 800;
                            color: #ea580c;
                        ">
                            Rs. {{ number_format($order->grand_total, 2) }}
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
                        📦 Order Summary
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

                                            <div style="
                                                margin-top: 5px;
                                                font-size: 12px;
                                                color: #6b7280;
                                            ">
                                                Quantity: {{ $item->quantity }}
                                            </div>

                                        </td>


                                        <td style="
                                            width: 35%;
                                            text-align: right;
                                            vertical-align: top;
                                        ">

                                            <div style="
                                                font-size: 14px;
                                                font-weight: 700;
                                                color: #ea580c;
                                            ">
                                                Rs.
                                                {{ number_format($item->price * $item->quantity, 2) }}
                                            </div>

                                        </td>

                                    </tr>
                                </table>

                            </div>

                        @endforeach


                        {{-- Total --}}
                        <div style="
                            padding: 16px 0;
                        ">

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>

                                    <td style="
                                        font-size: 16px;
                                        font-weight: 700;
                                        color: #111827;
                                    ">
                                        Total
                                    </td>

                                    <td style="
                                        text-align: right;
                                        font-size: 18px;
                                        font-weight: 800;
                                        color: #ea580c;
                                    ">
                                        Rs. {{ number_format($order->grand_total, 2) }}
                                    </td>

                                </tr>
                            </table>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    PROCESSING INFORMATION
                ================================================== --}}
                <div style="
                    background: #fff7ed;
                    border: 1px solid #fed7aa;
                    border-left: 4px solid #f59e0b;
                    border-radius: 10px;
                    padding: 17px 18px;
                    margin-bottom: 25px;
                ">

                    <div style="
                        font-size: 15px;
                        font-weight: 700;
                        color: #9a3412;
                        margin-bottom: 6px;
                    ">
                        🔄 We're preparing your order
                    </div>

                    <p style="
                        margin: 0;
                        font-size: 13px;
                        line-height: 1.7;
                        color: #7c2d12;
                    ">
                        Our team is currently processing your order.
                        You will receive another notification when your
                        order has been shipped.
                    </p>

                </div>


                {{-- =================================================
                    TRACKING BUTTON
                ================================================== --}}
                <div style="
                    text-align: center;
                    margin-top: 28px;
                    margin-bottom: 5px;
                ">

                    <a href="{{ route('orders.track', $order->id) }}"
                        style="
                            display: inline-block;
                            background: #f59e0b;
                            color: #ffffff;
                            text-decoration: none;
                            padding: 12px 28px;
                            border-radius: 8px;
                            font-size: 14px;
                            font-weight: 700;
                        ">
                        📦 Track Your Order
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
                    color: #ea580c;
                    margin-bottom: 8px;
                ">
                    Tech Nova
                </div>

                <p style="
                    margin: 0 0 6px;
                    font-size: 13px;
                    color: #6b7280;
                ">
                    Thank you for shopping with Tech Nova!
                </p>

                <p style="
                    margin: 0 0 6px;
                    font-size: 12px;
                    color: #9ca3af;
                ">
                    We will notify you once your order has been shipped.
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
