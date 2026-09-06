<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Cancelled</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f1f5f9;
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
                background: linear-gradient(135deg, #ef4444, #dc2626);
                padding: 35px 25px;
                text-align: center;
                color: #ffffff;
            ">

                {{-- Cancel Icon --}}
                <div style="
                    width: 65px;
                    height: 65px;
                    line-height: 65px;
                    margin: 0 auto 15px;
                    background: rgba(255,255,255,0.18);
                    border-radius: 50%;
                    font-size: 30px;
                ">
                    ✕
                </div>

                <h1 style="
                    margin: 0;
                    font-size: 26px;
                    font-weight: 700;
                ">
                    Order Cancelled
                </h1>

                <p style="
                    margin: 9px 0 0;
                    font-size: 14px;
                    color: #fee2e2;
                ">
                    Your Tech Nova order has been cancelled
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
                    We're writing to let you know that your order
                    <strong style="color: #111827;">
                        #{{ $order->order_number ?? $order->id }}
                    </strong>
                    has been cancelled.
                </p>


                {{-- =================================================
                    ORDER SUMMARY
                ================================================== --}}
                <div style="
                    border: 1px solid #fecaca;
                    border-radius: 12px;
                    overflow: hidden;
                    margin-bottom: 25px;
                ">

                    {{-- Status --}}
                    <div style="
                        padding: 16px 18px;
                        background: #fff7f7;
                        border-bottom: 1px solid #fee2e2;
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
                            background: #ef4444;
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
                            color: #111827;
                        ">
                            #{{ $order->order_number ?? $order->id }}
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
                            font-weight: 700;
                            color: #dc2626;
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
                                padding: 14px 0;
                                border-bottom: 1px solid #e5e7eb;
                            ">

                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>

                                        <td style="
                                            font-size: 14px;
                                            color: #374151;
                                            font-weight: 600;
                                            padding-right: 10px;
                                        ">
                                            {{ $item->product->name ?? 'Product' }}
                                        </td>

                                        <td style="
                                            text-align: right;
                                            font-size: 14px;
                                            color: #6b7280;
                                            white-space: nowrap;
                                        ">
                                            × {{ $item->quantity }}
                                        </td>

                                    </tr>
                                </table>

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- =================================================
                    INFORMATION MESSAGE
                ================================================== --}}
                <div style="
                    background: #fff7ed;
                    border-left: 4px solid #f97316;
                    border-radius: 8px;
                    padding: 16px 18px;
                    margin-bottom: 25px;
                ">

                    <p style="
                        margin: 0;
                        font-size: 14px;
                        line-height: 1.7;
                        color: #7c2d12;
                    ">
                        If you believe this cancellation was made in error
                        or if you have any questions, please contact our
                        support team. We're happy to help.
                    </p>

                </div>


                {{-- =================================================
                    SUPPORT BUTTON
                ================================================== --}}
                <div style="
                    text-align: center;
                    margin-top: 28px;
                ">

                    <a href="#"
                        style="
                            display: inline-block;
                            background: #2563eb;
                            color: #ffffff;
                            text-decoration: none;
                            padding: 12px 26px;
                            border-radius: 8px;
                            font-size: 14px;
                            font-weight: 600;
                        ">
                        Contact Support
                    </a>

                </div>

            </div>


            {{-- =====================================================
                FOOTER
            ====================================================== --}}
            <div style="
                background: #f8fafc;
                border-top: 1px solid #e5e7eb;
                padding: 24px 20px;
                text-align: center;
            ">

                <div style="
                    font-size: 18px;
                    font-weight: 700;
                    color: #2563eb;
                    margin-bottom: 7px;
                ">
                    Tech Nova
                </div>

                <p style="
                    margin: 0 0 6px;
                    font-size: 13px;
                    color: #6b7280;
                ">
                    Thank you for choosing Tech Nova.
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
