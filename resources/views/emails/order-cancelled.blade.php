<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Order Cancelled</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 p-0 bg-[#f1f5f9] font-sans text-[#1f2937] antialiased">

    <div class="w-full p-[30px_12px] sm:p-[40px_15px] box-border">

        <div class="w-full max-w-[650px] mx-auto bg-white rounded-2xl sm:rounded-[18px] overflow-hidden shadow-[0_10px_35px_rgba(0,0,0,0.08)]">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="bg-gradient-to-br from-[#ef4444] to-[#dc2626] p-[28px_20px] sm:p-[35px_25px] text-center text-white">

                {{-- Cancel Icon --}}
                <div class="w-[58px] h-[58px] sm:w-[65px] sm:h-[65px]
                            leading-[58px] sm:leading-[65px]
                            mx-auto mb-[15px]
                            bg-[rgba(255,255,255,0.18)] rounded-full
                            text-[26px] sm:text-[30px]">
                    ✕
                </div>

                <h1 class="m-0 text-[22px] sm:text-[26px] font-bold leading-snug">
                    Order Cancelled
                </h1>

                <p class="m-0 mt-[9px] text-[13px] sm:text-[14px] text-[#fee2e2] leading-relaxed">
                    Your Tech Nova order has been cancelled
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
                    We're writing to let you know that your order
                    <strong class="text-[#111827]">
                        #{{ $order->order_number ?? $order->id }}
                    </strong>
                    has been cancelled.
                </p>


                {{-- =================================================
                    ORDER SUMMARY
                ================================================== --}}
                <div class="border border-[#fecaca] rounded-xl overflow-hidden mb-[25px]">

                    {{-- Status --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px] bg-[#fff7f7] border-b border-[#fee2e2]">

                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[7px] uppercase tracking-[0.5px]">
                            Order Status
                        </div>

                        <span class="inline-block bg-[#ef4444] text-white
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

                        <div class="text-[15px] sm:text-[16px] font-bold text-[#111827] break-words">
                            #{{ $order->order_number ?? $order->id }}
                        </div>

                    </div>


                    {{-- Grand Total --}}
                    <div class="p-[14px_16px] sm:p-[16px_18px]">

                        <div class="text-[11px] sm:text-[12px] text-[#6b7280] mb-[5px] uppercase tracking-[0.5px]">
                            Grand Total
                        </div>

                        <div class="text-[18px] sm:text-[20px] font-bold text-[#dc2626]">
                            Rs. {{ number_format($order->grand_total, 2) }}
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

                            <div class="py-[14px] border-b border-[#e5e7eb] last:border-b-0">

                                <table class="w-full border-collapse">
                                    <tr>

                                        <td class="text-[13px] sm:text-[14px] text-[#374151]
                                                   font-semibold pr-[10px]
                                                   break-words align-top">
                                            {{ $item->product->name ?? 'Product' }}
                                        </td>

                                        <td class="text-right text-[13px] sm:text-[14px]
                                                   text-[#6b7280] whitespace-nowrap
                                                   align-top">
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
                <div class="bg-[#fff7ed] border-l-4 border-[#f97316]
                            rounded-lg p-[14px_16px] sm:p-[16px_18px]
                            mb-[25px]">

                    <p class="m-0 text-[13px] sm:text-[14px] leading-[1.7] text-[#7c2d12]">
                        If you believe this cancellation was made in error
                        or if you have any questions, please contact our
                        support team. We're happy to help.
                    </p>

                </div>


                {{-- =================================================
                    SUPPORT BUTTON
                ================================================== --}}
                <div class="text-center mt-[28px]">

                    <a href="#"
                        class="block sm:inline-block w-full sm:w-auto text-center
                               bg-[#2563eb] hover:bg-[#1d4ed8]
                               text-white no-underline
                               px-[22px] py-[12px] sm:px-[26px]
                               rounded-lg text-[13px] sm:text-[14px]
                               font-semibold leading-snug
                               transition-colors duration-200">
                        Contact Support
                    </a>

                </div>

            </div>


            {{-- =====================================================
                FOOTER
            ====================================================== --}}
            <div class="bg-[#f8fafc] border-t border-[#e5e7eb]
                        p-[20px_18px] sm:p-[24px_20px] text-center">

                <div class="text-[16px] sm:text-[18px] font-bold text-[#2563eb] mb-[7px]">
                    Tech Nova
                </div>

                <p class="m-0 mb-[6px] text-[12px] sm:text-[13px] text-[#6b7280] leading-relaxed">
                    Thank you for choosing Tech Nova.
                </p>

                <p class="m-0 text-[11px] sm:text-[12px] text-[#9ca3af] leading-relaxed">
                    © {{ date('Y') }} Tech Nova. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</body>

</html>
