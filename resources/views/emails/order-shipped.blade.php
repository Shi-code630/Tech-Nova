<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Order Shipped</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 p-0 bg-[#eff6ff] font-sans text-[#1f2937] antialiased">

    <div class="w-full p-[30px_12px] sm:p-[40px_15px] box-border">

        <div class="w-full max-w-[650px] mx-auto bg-white rounded-2xl sm:rounded-[18px] overflow-hidden shadow-[0_10px_35px_rgba(0,0,0,0.08)]">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="bg-gradient-to-br from-[#2563eb] to-[#1d4ed8] p-[28px_20px] sm:p-[35px_25px] text-center text-white">

                {{-- Shipping Icon --}}
                <div class="w-[58px] h-[58px] sm:w-[65px] sm:h-[65px]
                            leading-[58px] sm:leading-[65px]
                            mx-auto mb-[15px]
                            bg-[rgba(255,255,255,0.18)] rounded-full
                            text-[26px] sm:text-[30px]">
                    🚚
                </div>

                <h1 class="m-0 text-[22px] sm:text-[26px] font-bold leading-snug">
                    Tech Nova
                </h1>

                <p class="m-0 mt-[9px] text-[13px] sm:text-[15px] text-[#dbeafe] leading-relaxed">
                    Your Order Is On Its Way!
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
                    Great news! 🎉 Your order
                    <strong class="text-[#111827]">
                        #{{ $order->order_number ?? $order->id }}
                    </strong>
                    has been shipped and is now on its way to you.
                </p>


                {{-- =================================================
                    SHIPPING SUMMARY
                ================================================== --}}
                <div class="border border-[#bfdbfe] rounded-xl overflow-hidden mb-[25px]">

                    {{-- Status --}}
                    <div class="p-[15px_16px] sm:p-[17px_18px] bg-[#eff6ff] border-b border-[#dbeafe]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[7px] uppercase tracking-[0.5px]">
                            Order Status
                        </div>
                        <span class="inline-block bg-[#2563eb] text-white
                                     px-[14px] py-[5px] sm:px-[15px] sm:py-[6px]
                                     rounded-full text-[11px] sm:text-[12px] font-bold">
                            {{ $order->status_label }}
                        </span>
                    </div>


                    {{-- Order ID --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] border-b border-[#e5e7eb]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Order ID
                        </div>
                        <div class="text-[15px] sm:text-[16px] font-bold text-[#2563eb] break-words">
                            #{{ $order->order_number ?? $order->id }}
                        </div>
                    </div>


                    {{-- Shipped Date --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] border-b border-[#e5e7eb]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Shipped Date
                        </div>
                        <div class="text-[14px] sm:text-[15px] font-semibold text-[#111827] break-words">
                            {{ $order->shipped_at
                                ? $order->shipped_at->format('d M Y, h:i A')
                                : 'N/A' }}
                        </div>
                    </div>


                    {{-- Estimated Delivery --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] border-b border-[#e5e7eb]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Estimated Delivery
                        </div>
                        <div class="text-[14px] sm:text-[15px] font-bold text-[#15803d] break-words">
                            3–5 Business Days
                        </div>
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
                        📦 Shipped Items
                    </h3>

                    <div class="bg-[#f8fafc] border border-[#e2e8f0] rounded-xl px-[14px] sm:px-[18px] py-[5px]">

                        @foreach ($order->items as $item)

                            <div class="py-[14px] sm:py-[15px] border-b border-[#e5e7eb] last:border-b-0">

                                <table class="w-full border-collapse">
                                    <tr>

                                        {{-- Left: Product + variant --}}
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


                                        {{-- Right: Line total + Qty --}}
                                        <td class="w-[35%] text-right align-top">
                                            <div class="text-[13px] sm:text-[14px] font-bold text-[#2563eb] whitespace-nowrap">
                                                Rs. {{ number_format($item->price * $item->quantity, 2) }}
                                            </div>
                                            <div class="mt-[5px] text-[11px] sm:text-[12px] text-[#6b7280]">
                                                Qty: {{ $item->quantity }}
                                            </div>
                                        </td>

                                    </tr>
                                </table>

                            </div>

                        @endforeach


                        {{-- Grand Total --}}
                        <div class="py-[14px] sm:py-[16px]">
                            <table class="w-full border-collapse">
                                <tr>
                                    <td class="text-[14px] sm:text-[16px] font-bold text-[#111827]">
                                        Grand Total
                                    </td>
                                    <td class="text-right text-[16px] sm:text-[18px] font-extrabold text-[#2563eb] whitespace-nowrap">
                                        Rs. {{ number_format($order->grand_total, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>


                {{-- =================================================
                    SHIPPING MESSAGE
                ================================================== --}}
                <div class="bg-[#eff6ff] border border-[#bfdbfe] border-l-4 border-l-[#2563eb]
                            rounded-[10px] p-[15px_16px] sm:p-[17px_18px] mb-[25px]">

                    <div class="text-[14px] sm:text-[15px] font-bold text-[#1e3a8a] mb-[6px]">
                        🚚 Your package is on the way
                    </div>

                    <p class="m-0 text-[12px] sm:text-[13px] leading-[1.7] text-[#475569]">
                        Your order has left our facility and is currently
                        on its way to your delivery address. You can track
                        the latest status using the button below.
                    </p>

                </div>


                {{-- =================================================
                    TRACKING BUTTON
                ================================================== --}}
                <div class="text-center mt-[28px] mb-[5px]">

                    <a href="{{ route('orders.track', $order->id) }}"
                        class="block sm:inline-block w-full sm:w-auto text-center
                               bg-[#2563eb] hover:bg-[#1d4ed8]
                               text-white no-underline
                               px-[22px] py-[13px] sm:px-[30px]
                               rounded-lg text-[13px] sm:text-[14px]
                               font-bold leading-snug
                               transition-colors duration-200">
                        🚚 Track Your Order
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
                    Thank you for shopping with Tech Nova!
                </p>

                <p class="m-0 mb-[6px] text-[11px] sm:text-[12px] text-[#9ca3af] leading-relaxed">
                    We hope you enjoy your purchase!
                </p>

                <p class="m-0 text-[11px] sm:text-[12px] text-[#9ca3af] leading-relaxed">
                    © {{ date('Y') }} Tech Nova. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</body>

</html>
