{{-- =========================================================
    SPIN & WIN
    resources/views/frontend/spin.blade.php
========================================================= --}}

@php
    $spinRewards = \App\Models\SpinReward::query()
        ->where('status', true)
        ->where('probability', '>', 0)
        ->where(function ($query) {
            $query->whereNull('stock')
                ->orWhere('stock', '>', 0);
        })
        ->orderBy('id')
        ->get();
@endphp


{{-- =========================================================
    SPIN & WIN BUTTON
========================================================= --}}

<div class="relative">

    <button
        type="button"
        onclick="openSpinWheel()"
        class="group flex items-center gap-2 px-2 py-1 rounded-xl
               bg-gradient-to-r from-yellow-400 to-orange-500
               text-white font-bold text-sm
               shadow-md hover:shadow-lg
               hover:scale-105 transition-all duration-200"
    >

        <span class="text-lg group-hover:rotate-180 transition-transform duration-500">
            🎡
        </span>

        <span class="hidden sm:inline">
            Spin & Win
        </span>

    </button>

</div>


{{-- =========================================================
    SPIN MODAL
========================================================= --}}

<div
    id="spinWheelModal"
    class="fixed inset-0 z-[99999] hidden items-center justify-center
           bg-black/70 backdrop-blur-sm p-4"
>

    <div
        class="relative w-full max-w-lg rounded-3xl
               bg-white shadow-2xl overflow-hidden"
    >

        {{-- CLOSE --}}
        <button
            type="button"
            onclick="closeSpinWheel()"
            class="absolute right-4 top-4 z-20
                   flex h-9 w-9 items-center justify-center
                   rounded-full bg-gray-100 text-gray-600
                   hover:bg-red-500 hover:text-white transition"
        >
            ✕
        </button>


        {{-- HEADER --}}
        <div
            class="bg-gradient-to-r from-blue-600 to-indigo-600
                   px-6 py-5 text-center text-white"
        >

            <div class="text-4xl">
                🎡
            </div>

            <h2 class="mt-1 text-2xl font-extrabold">
                Spin & Win
            </h2>

            <p class="mt-1 text-sm text-blue-100">
                Spin the wheel and win exciting rewards!
            </p>

        </div>


        {{-- =================================================
            WHEEL
        ================================================== --}}

        <div class="flex justify-center px-6 pt-7">

            <div class="relative">

                {{-- POINTER --}}
                <div
                    class="absolute left-1/2 top-[-10px] z-30
                           -translate-x-1/2 text-3xl"
                >
                    🔻
                </div>


                {{-- WHEEL --}}
                <div
                    id="spinWheel"
                    class="relative h-72 w-72 rounded-full
                           border-8 border-yellow-400
                           shadow-xl overflow-hidden
                           transition-transform
                           duration-[5000ms]
                           ease-out"
                >

                    @if($spinRewards->count())

                        @php
                            $rewardCount = $spinRewards->count();

                            $segmentAngle = 360 / $rewardCount;

                            $gradientParts = [];

                            foreach ($spinRewards as $index => $reward) {
                                $start = $index * $segmentAngle;
                                $end = ($index + 1) * $segmentAngle;

                                $colors = [
                                    '#ef4444',
                                    '#f97316',
                                    '#facc15',
                                    '#22c55e',
                                    '#06b6d4',
                                    '#3b82f6',
                                    '#6366f1',
                                    '#a855f7',
                                ];

                                $color = $colors[$index % count($colors)];

                                $gradientParts[] =
                                    "{$color} {$start}deg {$end}deg";
                            }
                        @endphp


                        {{-- COLORED WHEEL --}}
                        <div
                            class="absolute inset-0 rounded-full"
                            style="background: conic-gradient(
                                {{ implode(',', $gradientParts) }}
                            );"
                        ></div>


                        {{-- REWARD LABELS --}}
                        @foreach($spinRewards as $index => $reward)

                            @php
                                $angle =
                                    ($index * $segmentAngle)
                                    + ($segmentAngle / 2);
                            @endphp

                            <div
                                class="absolute left-1/2 top-1/2
                                       w-[92px]
                                       text-center
                                       text-[11px]
                                       font-extrabold
                                       text-white
                                       drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]"
                                style="
                                    transform:
                                        translate(-50%, -50%)
                                        rotate({{ $angle }}deg)
                                        translateY(-92px)
                                        rotate(-{{ $angle }}deg);
                                "
                            >
                                {{ $reward->name }}
                            </div>

                        @endforeach

                    @else

                        <div
                            class="absolute inset-0 flex items-center
                                   justify-center bg-gray-200"
                        >
                            <span class="text-sm font-bold text-gray-600">
                                No rewards available
                            </span>
                        </div>

                    @endif


                    {{-- CENTER --}}
                    <div
                        class="absolute left-1/2 top-1/2
                               z-20
                               h-20 w-20
                               -translate-x-1/2
                               -translate-y-1/2
                               rounded-full
                               bg-white
                               shadow-lg
                               flex items-center
                               justify-center
                               text-3xl"
                    >
                        🎁
                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
            SPIN BUTTON
        ================================================== --}}

        <div class="px-6 py-6 text-center">

            <button
                id="spinNowButton"
                type="button"
                onclick="spinNow()"
                class="w-full rounded-xl
                       bg-gradient-to-r
                       from-yellow-400
                       to-orange-500
                       px-6 py-3
                       text-lg font-extrabold
                       text-white shadow-lg
                       hover:scale-[1.02]
                       transition
                       disabled:cursor-not-allowed
                       disabled:opacity-60"
            >
                🎡 SPIN NOW
            </button>


            <p
                id="spinMessage"
                class="mt-3 hidden text-sm font-medium"
            ></p>

        </div>

    </div>

</div>


{{-- =========================================================
    WINNER POPUP
========================================================= --}}

<div
    id="spinWinnerModal"
    class="fixed inset-0 z-[100000]
           hidden items-center justify-center
           bg-black/70 backdrop-blur-sm p-4"
>

    <div
        class="relative w-full max-w-sm
               rounded-3xl bg-white
               shadow-2xl p-6 text-center"
    >

        <button
            type="button"
            onclick="closeWinnerPopup()"
            class="absolute right-4 top-4
                   h-8 w-8 rounded-full
                   bg-gray-100 text-gray-600
                   hover:bg-red-500
                   hover:text-white transition"
        >
            ✕
        </button>


        <div class="text-5xl">
            🎉
        </div>


        <h2 class="mt-3 text-2xl font-extrabold text-gray-900">
            Congratulations!
        </h2>


        <p class="mt-2 text-sm text-gray-500">
            You Won
        </p>


        <div
            id="winnerRewardName"
            class="mt-2 text-2xl font-extrabold text-orange-500"
        ></div>


        <p
            id="winnerRewardDescription"
            class="mt-2 text-sm text-gray-500"
        ></p>


        <button
            id="claimRewardButton"
            type="button"
            onclick="claimSpinReward()"
            class="mt-6 w-full rounded-xl
                   bg-gradient-to-r
                   from-blue-600 to-indigo-600
                   px-6 py-3
                   text-lg font-bold
                   text-white shadow-lg
                   hover:scale-[1.02]
                   transition"
        >
            🎁 Claim Reward
        </button>

    </div>

</div>


{{-- =========================================================
    JAVASCRIPT
========================================================= --}}

<script>

let spinAttemptId = null;

let spinReward = null;

let isSpinning = false;

let currentRotation = 0;


/*
|--------------------------------------------------------------------------
| OPEN
|--------------------------------------------------------------------------
*/

function openSpinWheel()
{
    const modal =
        document.getElementById('spinWheelModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('hidden');

    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');
}


/*
|--------------------------------------------------------------------------
| CLOSE
|--------------------------------------------------------------------------
*/

function closeSpinWheel()
{
    if (isSpinning) {
        return;
    }

    const modal =
        document.getElementById('spinWheelModal');

    if (!modal) {
        return;
    }

    modal.classList.add('hidden');

    modal.classList.remove('flex');

    document.body.classList.remove('overflow-hidden');
}


/*
|--------------------------------------------------------------------------
| SPIN
|--------------------------------------------------------------------------
*/

async function spinNow()
{
    if (isSpinning) {
        return;
    }

    isSpinning = true;


    const button =
        document.getElementById('spinNowButton');

    const message =
        document.getElementById('spinMessage');

    const wheel =
        document.getElementById('spinWheel');


    button.disabled = true;

    button.innerHTML =
        '⏳ Spinning...';


    message.classList.remove('hidden');

    message.className =
        'mt-3 text-center text-sm font-semibold text-blue-600';

    message.innerText =
        'Your reward is being selected...';


    try {

        const response = await fetch(
            "{{ route('spin-and-win.spin') }}",
            {
                method: 'POST',

                headers: {
                    'Content-Type':
                        'application/json',

                    'Accept':
                        'application/json',

                    'X-CSRF-TOKEN':
                        document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            .getAttribute(
                                'content'
                            )
                },

                body: JSON.stringify({})
            }
        );


        const data =
            await response.json();


        if (!response.ok || !data.success) {

            throw new Error(
                data.message ||
                'Unable to spin right now.'
            );
        }


        spinAttemptId =
            data.attempt_id;

        spinReward =
            data.reward;


        /*
        |--------------------------------------------------------------------------
        | Backend gives exact reward position
        |--------------------------------------------------------------------------
        */

        const rewardIndex =
            Number.isInteger(data.reward_index)
                ? data.reward_index
                : 0;


        const rewardCount =
            {{ $spinRewards->count() }};


        const segmentAngle =
            rewardCount > 0
                ? 360 / rewardCount
                : 360;


        const targetAngle =
            rewardIndex * segmentAngle +
            (segmentAngle / 2);


        const extraSpins =
            5 * 360;


        const finalRotation =
            currentRotation +
            extraSpins +
            (360 - targetAngle);


        currentRotation =
            finalRotation;


        wheel.style.transform =
            `rotate(${finalRotation}deg)`;


        setTimeout(function () {

            isSpinning = false;

            button.disabled = false;

            button.innerHTML =
                '🎡 SPIN NOW';

            message.classList.add(
                'hidden'
            );

            showWinnerPopup();

        }, 5200);


    } catch (error) {

        console.error(error);


        isSpinning = false;

        button.disabled = false;

        button.innerHTML =
            '🎡 SPIN NOW';


        message.classList.remove(
            'hidden'
        );


        message.className =
            'mt-3 text-center text-sm font-semibold text-red-600';


        message.innerText =
            error.message ||
            'Something went wrong.';
    }
}


/*
|--------------------------------------------------------------------------
| WINNER
|--------------------------------------------------------------------------
*/

function showWinnerPopup()
{
    if (!spinReward) {
        return;
    }


    document.getElementById(
        'winnerRewardName'
    ).innerText =
        spinReward.name;


    document.getElementById(
        'winnerRewardDescription'
    ).innerText =
        spinReward.description ||
        'Congratulations! You won this reward.';


    const modal =
        document.getElementById(
            'spinWinnerModal'
        );


    modal.classList.remove(
        'hidden'
    );

    modal.classList.add(
        'flex'
    );
}


/*
|--------------------------------------------------------------------------
| CLOSE WINNER
|--------------------------------------------------------------------------
*/

function closeWinnerPopup()
{
    const modal =
        document.getElementById(
            'spinWinnerModal'
        );


    modal.classList.add(
        'hidden'
    );

    modal.classList.remove(
        'flex'
    );
}


/*
|--------------------------------------------------------------------------
| CLAIM
|--------------------------------------------------------------------------
*/

async function claimSpinReward()
{
    if (!spinAttemptId) {

        alert(
            'Spin reward information is missing.'
        );

        return;
    }


    const button =
        document.getElementById(
            'claimRewardButton'
        );


    button.disabled = true;

    button.innerHTML =
        '⏳ Claiming...';


    try {

        const response =
            await fetch(
                "{{ route('spin-and-win.claim') }}",
                {
                    method: 'POST',

                    headers: {
                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                .getAttribute(
                                    'content'
                                )
                    },

                    body: JSON.stringify({
                        attempt_id:
                            spinAttemptId
                    })
                }
            );


        const data =
            await response.json();


        if (!response.ok || !data.success) {

            throw new Error(
                data.message ||
                'Unable to claim reward.'
            );
        }


        button.innerHTML =
            '✅ Reward Claimed';


        button.classList.remove(
            'from-blue-600',
            'to-indigo-600'
        );


        button.classList.add(
            'bg-green-600'
        );


        /*
        |--------------------------------------------------------------------------
        | AUTOMATIC REDIRECT
        |--------------------------------------------------------------------------
        */

        setTimeout(function () {

            /*
             * DISCOUNT → COUPONS PAGE
             */
            if (
                data.reward &&
                data.reward.type === 'discount'
            ) {

                window.location.href =
                    "{{ route('user.coupons') }}";

                return;
            }


            /*
             * COINS → USER DASHBOARD
             */
            if (
                data.reward &&
                data.reward.type === 'coins'
            ) {

                window.location.href =
                    "{{ route('user.dashboard') }}";

                return;
            }


            /*
             * GIFT → CLOSE POPUP
             */
            closeWinnerPopup();

            closeSpinWheel();

            button.disabled = false;

            button.innerHTML =
                '🎁 Claim Reward';

            button.classList.remove(
                'bg-green-600'
            );

            button.classList.add(
                'bg-gradient-to-r',
                'from-blue-600',
                'to-indigo-600'
            );

        }, 1200);


    } catch (error) {

        console.error(error);

        button.disabled = false;

        button.innerHTML =
            '🎁 Claim Reward';


        alert(
            error.message ||
            'Something went wrong.'
        );
    }
}

</script>
