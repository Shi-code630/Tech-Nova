<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Order Delivered</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 p-0 bg-[#f0fdf4] font-sans text-[#1f2937] antialiased">

    <div class="w-full p-[30px_12px] sm:p-[40px_15px] box-border">

        <div class="w-full max-w-[650px] mx-auto bg-white rounded-2xl sm:rounded-[18px] overflow-hidden shadow-[0_10px_35px_rgba(0,0,0,0.08)]">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="bg-gradient-to-br from-[#16a34a] to-[#15803d] p-[28px_20px] sm:p-[35px_25px] text-center text-white">

                {{-- Success Icon --}}
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

                <p class="m-0 mt-[9px] text-[13px] sm:text-[15px] text-[#dcfce7] leading-relaxed">
                    Your Order Has Been Delivered!
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
                    has been successfully delivered.
                    We hope you enjoy your purchase!
                </p>


                {{-- =================================================
                    DELIVERY SUMMARY
                ================================================== --}}
                <div class="border border-[#bbf7d0] rounded-xl overflow-hidden mb-[25px]">

                    {{-- Status --}}
                    <div class="p-[15px_16px] sm:p-[17px_18px] bg-[#f0fdf4] border-b border-[#dcfce7]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[7px] uppercase tracking-[0.5px]">
                            Order Status
                        </div>
                        <span class="inline-block bg-[#16a34a] text-white
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
                        <div class="text-[15px] sm:text-[16px] font-bold text-[#15803d] break-words">
                            #{{ $order->order_number ?? $order->id }}
                        </div>
                    </div>


                    {{-- Delivered Date --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] border-b border-[#e5e7eb]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Delivered Date
                        </div>
                        <div class="text-[14px] sm:text-[15px] font-semibold text-[#111827] break-words">
                            {{ $order->delivered_at
                                ? $order->delivered_at->format('d M Y, h:i A')
                                : 'N/A' }}
                        </div>
                    </div>


                    {{-- Grand Total --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px]">
                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Grand Total
                        </div>
                        <div class="text-[18px] sm:text-[20px] font-extrabold text-[#15803d]">
                            Rs. {{ number_format($order->grand_total, 2) }}
                        </div>
                    </div>

                </div>


                {{-- =================================================
                    ORDER ITEMS
                ================================================== --}}
                <div class="mb-[25px]">

                    <h3 class="m-0 mb-[12px] text-[15px] sm:text-[17px] text-[#111827] font-semibold">
                        📦 Delivered Items
                    </h3>

                    <div class="bg-[#f8fafc] border border-[#e2e8f0] rounded-xl px-[14px] sm:px-[18px] py-[5px]">

                        @foreach ($order->items as $item)

                            <div class="py-[14px] sm:py-[15px] border-b border-[#e5e7eb] last:border-b-0">

                                <table class="w-full border-collapse">
                                    <tr>

                                        {{-- Left: Product + variant --}}
                                        <td class="w-[70%] align-top pr-[10px]">
                                            <div class="text-[13px] sm:text-[14px] font-bold text-[#111827] leading-[1.5] break-words">
                                                {{ $item->product->name ?? 'Product' }}
                                            </div>

                                            @if ($item->variant)
                                                <div class="mt-[5px] text-[11px] sm:text-[12px] text-[#6b7280]">
                                                    Variant: {{ $item->variant->full_name ?? 'Standard' }}
                                                </div>
                                            @endif
                                        </td>


                                        {{-- Right: Qty --}}
                                        <td class="w-[30%] text-right align-top">
                                            <div class="text-[13px] sm:text-[14px] font-bold text-[#15803d] whitespace-nowrap">
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
                    REVIEW SECTION
                ================================================== --}}
                <div class="bg-[#f0fdf4] border border-[#bbf7d0] rounded-[14px]
                            p-[20px_16px] sm:p-[25px_20px] text-center mb-[10px]">

                    <div class="text-[24px] sm:text-[27px] mb-[8px]">
                        ⭐⭐⭐⭐⭐
                    </div>

                    <h3 class="m-0 mb-[8px] text-[16px] sm:text-[18px] text-[#166534] font-semibold">
                        Loved Your Purchase?
                    </h3>

                    <p class="m-0 mx-auto mb-[18px] max-w-[450px]
                              text-[12px] sm:text-[13px] leading-[1.7] text-[#64748b]">
                        We'd love to hear about your experience.
                        Your review helps us improve and helps other
                        customers make better choices.
                    </p>

                    <a href="{{ route('orders.review', $order->id) }}"
                        class="block sm:inline-block w-full sm:w-auto text-center
                               bg-[#16a34a] hover:bg-[#15803d]
                               text-white no-underline
                               px-[22px] py-[12px] sm:px-[28px]
                               rounded-lg text-[13px] sm:text-[14px]
                               font-bold leading-snug
                               transition-colors duration-200">
                        ⭐ Write a Review
                    </a>

                </div>

            </div>


            {{-- =====================================================
                FOOTER
            ====================================================== --}}
            <div class="bg-[#f8fafc] border-t border-[#e5e7eb]
                        p-[20px_18px] sm:p-[25px_20px] text-center">

                <div class="text-[17px] sm:text-[19px] font-extrabold text-[#16a34a] mb-[8px]">
                    Tech Nova
                </div>

                <p class="m-0 mb-[6px] text-[12px] sm:text-[13px] text-[#6b7280] leading-relaxed">
                    Thank you for shopping with Tech Nova!
                </p>

                <p class="m-0 mb-[6px] text-[11px] sm:text-[12px] text-[#9ca3af] leading-relaxed">
                    We hope to serve you again soon. 🛍️
                </p>

                <p class="m-0 text-[11px] sm:text-[12px] text-[#9ca3af] leading-relaxed">
                    © {{ date('Y') }} Tech Nova. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</body>

</html>
