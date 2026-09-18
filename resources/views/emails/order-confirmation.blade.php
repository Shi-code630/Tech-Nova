<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Order Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 p-0 bg-[#eef4ff] font-sans text-[#1f2937] antialiased">

    <div class="w-full p-[30px_12px] sm:p-[40px_15px] box-border">

        <div class="w-full max-w-[650px] mx-auto bg-white rounded-2xl sm:rounded-[18px] overflow-hidden shadow-[0_10px_35px_rgba(0,0,0,0.08)]">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="bg-gradient-to-br from-[#2563eb] to-[#1d4ed8] p-[28px_20px] sm:p-[35px_25px] text-center text-white">

                <div class="w-[58px] h-[58px] sm:w-[65px] sm:h-[65px]
                            leading-[58px] sm:leading-[65px]
                            mx-auto mb-[15px]
                            bg-[rgba(255,255,255,0.18)] rounded-full
                            text-[26px] sm:text-[30px]">
                    ✓
                </div>

                <h1 class="m-0 text-[22px] sm:text-[26px] font-bold leading-snug">
                    Tech Nova
                </h1>

                <p class="m-0 mt-[9px] text-[13px] sm:text-[15px] text-[#dbeafe] leading-relaxed">
                    Order Confirmed Successfully
                </p>

            </div>


            {{-- =====================================================
                CONTENT
            ====================================================== --}}
            <div class="p-[22px_18px] sm:p-[30px_25px]">

                {{-- Greeting --}}
                <h2 class="m-0 mb-[10px] text-[18px] sm:text-[21px] text-[#111827] font-semibold leading-snug">
                    Dear {{ $order->user->name ?? 'Customer' }},
                </h2>

                <p class="m-0 mb-[25px] text-[14px] sm:text-[15px] leading-[1.7] text-[#6b7280]">
                    Thank you for shopping with
                    <strong class="text-[#2563eb]">Tech Nova</strong>.
                    Your order has been successfully placed.
                    Here are your order details:
                </p>


                {{-- =================================================
                    ORDER INFORMATION
                ================================================== --}}
                <div class="border border-[#dbeafe] rounded-xl overflow-hidden mb-[25px]">

                    {{-- Order ID --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] bg-[#f8fbff] border-b border-[#e5e7eb]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Order ID
                        </div>
                        <div class="text-[15px] sm:text-[16px] font-bold text-[#2563eb] break-words">
                            #{{ $order->order_number ?? $order->id }}
                        </div>
                    </div>


                    {{-- Order Date --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] border-b border-[#e5e7eb]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Order Date
                        </div>
                        <div class="text-[14px] sm:text-[15px] font-semibold text-[#111827] break-words">
                            {{ $order->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>


                    {{-- Payment Method --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] border-b border-[#e5e7eb]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Payment Method
                        </div>
                        <div class="text-[14px] sm:text-[15px] font-semibold text-[#111827] break-words">
                            {{ $order->payment_method ?? 'N/A' }}
                        </div>
                    </div>


                    {{-- Payment Status --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] border-b border-[#e5e7eb]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[7px] uppercase tracking-[0.5px]">
                            Payment Status
                        </div>
                        <span class="inline-block bg-[#dcfce7] text-[#15803d]
                                     px-[12px] py-[5px] sm:px-[13px] sm:py-[6px]
                                     rounded-full text-[11px] sm:text-[12px] font-bold">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>


                    {{-- Order Status --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] border-b border-[#e5e7eb]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[7px] uppercase tracking-[0.5px]">
                            Order Status
                        </div>
                        <span class="inline-block bg-[#dbeafe] text-[#1d4ed8]
                                     px-[12px] py-[5px] sm:px-[13px] sm:py-[6px]
                                     rounded-full text-[11px] sm:text-[12px] font-bold">
                            {{ $order->status_label }}
                        </span>
                    </div>


                    {{-- Shipping Address --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Shipping Address
                        </div>
                        <div class="text-[13px] sm:text-[14px] leading-[1.6] font-semibold text-[#374151] break-words">
                            {{ $order->address->address ?? 'N/A' }}
                        </div>
                    </div>

                </div>


                {{-- =================================================
                    ORDER ITEMS
                ================================================== --}}
                <div class="mb-[25px]">

                    <h3 class="m-0 mb-[12px] text-[15px] sm:text-[17px] text-[#111827] font-semibold">
                        📦 Order Items
                    </h3>

                    <div class="bg-[#f8fafc] border border-[#e2e8f0] rounded-xl px-[14px] sm:px-[18px] py-[5px]">

                        @foreach ($order->items as $item)

                            <div class="py-[14px] sm:py-[15px] border-b border-[#e5e7eb] last:border-b-0">

                                <table class="w-full border-collapse">
                                    <tr>

                                        {{-- Left: Product name + variant --}}
                                        <td class="w-[65%] align-top pr-[10px]">
                                            <div class="text-[13px] sm:text-[14px] font-bold text-[#111827] leading-[1.5] break-words">
                                                {{ $item->product->name ?? 'Product' }}
                                            </div>

                                            @if ($item->variant)
                                                <div class="mt-[5px] text-[11px] sm:text-[12px] text-[#6b7280]">
                                                    Variant: {{ $item->variant->full_name ?? 'Standard' }}
                                                </div>
                                            @endif
                                        </td>


                                        {{-- Right: Price + Qty --}}
                                        <td class="w-[35%] text-right align-top">
                                            <div class="text-[13px] sm:text-[14px] font-bold text-[#2563eb]">
                                                Rs. {{ number_format($item->price, 2) }}
                                            </div>
                                            <div class="mt-[5px] text-[11px] sm:text-[12px] text-[#6b7280]">
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
                <div class="bg-[#f8fbff] border border-[#dbeafe] rounded-xl p-[16px] sm:p-[20px] mb-[25px]">

                    <h3 class="m-0 mb-[15px] text-[15px] sm:text-[17px] text-[#111827] font-semibold">
                        💰 Order Summary
                    </h3>


                    {{-- Subtotal --}}
                    <div class="py-[7px]">
                        <table class="w-full border-collapse">
                            <tr>
                                <td class="text-[13px] sm:text-[14px] text-[#6b7280]">Subtotal</td>
                                <td class="text-right text-[13px] sm:text-[14px] text-[#374151] font-semibold whitespace-nowrap">
                                    Rs. {{ number_format($order->subtotal, 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>


                    {{-- Discount --}}
                    @if ($order->discount > 0)
                        <div class="py-[7px]">
                            <table class="w-full border-collapse">
                                <tr>
                                    <td class="text-[13px] sm:text-[14px] text-[#16a34a]">Discount</td>
                                    <td class="text-right text-[13px] sm:text-[14px] text-[#16a34a] font-semibold whitespace-nowrap">
                                        -Rs. {{ number_format($order->discount, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endif


                    {{-- Delivery --}}
                    <div class="py-[7px]">
                        <table class="w-full border-collapse">
                            <tr>
                                <td class="text-[13px] sm:text-[14px] text-[#6b7280]">Delivery Charge</td>
                                <td class="text-right text-[13px] sm:text-[14px] text-[#374151] font-semibold whitespace-nowrap">
                                    Rs. {{ number_format($order->delivery_charge, 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>


                    {{-- Tax --}}
                    <div class="py-[7px] pb-[15px]">
                        <table class="w-full border-collapse">
                            <tr>
                                <td class="text-[13px] sm:text-[14px] text-[#6b7280]">Tax</td>
                                <td class="text-right text-[13px] sm:text-[14px] text-[#374151] font-semibold whitespace-nowrap">
                                    Rs. {{ number_format($order->tax, 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>


                    {{-- Grand Total --}}
                    <div class="border-t border-[#dbeafe] pt-[15px]">
                        <table class="w-full border-collapse">
                            <tr>
                                <td class="text-[15px] sm:text-[17px] font-bold text-[#111827]">
                                    Grand Total
                                </td>
                                <td class="text-right text-[18px] sm:text-[21px] font-extrabold text-[#2563eb] whitespace-nowrap">
                                    Rs. {{ number_format($order->grand_total, 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>


                {{-- =================================================
                    TRACKING BOX
                ================================================== --}}
                <div class="bg-[#eff6ff] border border-[#bfdbfe] rounded-xl
                            p-[18px] sm:p-[22px] text-center mb-[10px]">

                    <div class="text-[22px] sm:text-[26px] mb-[8px]">📦</div>

                    <h3 class="m-0 mb-[7px] text-[15px] sm:text-[17px] text-[#1e3a8a] font-semibold">
                        Track Your Order
                    </h3>

                    <p class="m-0 mb-[18px] text-[12px] sm:text-[13px] leading-[1.6] text-[#64748b]">
                        You can check your order status and delivery updates anytime.
                    </p>

                    <a href="{{ route('orders.track', $order->id) }}"
                        class="block sm:inline-block w-full sm:w-auto text-center
                               bg-[#2563eb] hover:bg-[#1d4ed8]
                               text-white no-underline
                               px-[22px] py-[12px] sm:px-[28px]
                               rounded-lg text-[13px] sm:text-[14px]
                               font-bold leading-snug
                               transition-colors duration-200">
                        Track Your Order
                    </a>

                </div>

            </div>


            {{-- =====================================================
                FOOTER
            ====================================================== --}}
            <div class="bg-[#f8fafc] border-t border-[#e5e7eb]
                        p-[20px_18px] sm:p-[25px_20px] text-center">

                <div class="text-[17px] sm:text-[19px] font-extrabold text-[#2563eb] mb-[8px]">
                    Tech Nova
                </div>

                <p class="m-0 mb-[6px] text-[12px] sm:text-[13px] text-[#6b7280] leading-relaxed">
                    Thank you for shopping with us!
                </p>

                <p class="m-0 mb-[6px] text-[11px] sm:text-[12px] text-[#9ca3af] leading-relaxed">
                    This is an automated email. Please do not reply to this email.
                </p>

                <p class="m-0 text-[11px] sm:text-[12px] text-[#9ca3af] leading-relaxed">
                    © {{ date('Y') }} Tech Nova. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</body>

</html>
