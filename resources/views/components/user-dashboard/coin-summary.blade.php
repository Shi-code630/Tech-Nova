@props(['coinSummary', 'recentTransactions'])

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">⭐ My Coins</h2>
        <a href="{{ route('user.coins') }}" class="text-sm text-blue-600 hover:underline">View All</a>
    </div>

    {{-- Coin Stats --}}
    <div class="grid grid-cols-4 gap-4 mb-4">
        <div class="bg-yellow-50 rounded-xl p-3 text-center">
            <p class="text-xs text-yellow-600">Available</p>
            <p class="text-2xl font-bold text-yellow-700" id="coin-available">{{ number_format($coinSummary['available']) }}</p>
        </div>

        <div class="bg-green-50 rounded-xl p-3 text-center">
            <p class="text-xs text-green-600">Value</p>
            <p class="text-2xl font-bold text-green-700">
                Rs. <span id="coin-value">{{ number_format($coinSummary['value'], 2) }}</span>
            </p>
        </div>

        <div class="bg-blue-50 rounded-xl p-3 text-center">
            <p class="text-xs text-blue-600">Total Earned</p>
            <p class="text-2xl font-bold text-blue-700" id="coin-total-earned">{{ number_format($coinSummary['total_earned']) }}</p>
        </div>


        <div class="bg-red-50 rounded-xl p-3 text-center">
            <p class="text-xs text-red-600">Total Redeemed</p>
            <p class="text-2xl font-bold text-red-700" id="coin-total-redeemed">{{ number_format($coinSummary['total_redeemed']) }}</p>
            <p class="text-[10px] text-red-400 mt-1">Coins used for discounts</p>
        </div>
    </div>

    {{-- Recent Transactions --}}
    @if($recentTransactions->count() > 0)
        <div class="border-t border-gray-100 pt-4">
            <h3 class="text-sm font-medium text-gray-600 mb-3">Recent Activity</h3>
            <div class="space-y-2">
                @foreach($recentTransactions as $transaction)
                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">{{ $transaction->type === 'earned' ? '📈' : '📉' }}</span>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $transaction->type === 'earned' ? 'Earned' : 'Redeemed' }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $transaction->remarks ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold {{ $transaction->type === 'earned' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'earned' ? '+' : '-' }}{{ number_format($transaction->points) }}
                            </p>
                            <p class="text-xs text-gray-400">{{ $transaction->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-500 text-center py-4 text-sm">No coin transactions yet.</p>
    @endif

    {{-- Earn/Redeem Info --}}
    <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between text-xs text-gray-400">
        <span>Earn: Rs.{{ $coinSummary['earn_rate'] ?? 100 }} = 1 Coin</span>
        <span>Redeem: {{ $coinSummary['redeem_rate'] ?? 20 }} Coins = Rs.1</span>
        <span>Max Discount: {{ $coinSummary['max_discount_percent'] ?? 10 }}%</span>
    </div>

</div>
