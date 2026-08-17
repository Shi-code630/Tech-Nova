<x-filament-widgets::widget>
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-6">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <x-filament::icon
                    icon="heroicon-o-bolt"
                    class="w-5 h-5 text-primary-500"
                />
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    {{ $this->getHeading() }}
                </h3>
            </div>
            <span class="text-xs text-gray-500 dark:text-gray-400">
                {{ count($actions) }} actions
            </span>
        </div>

        {{-- Actions Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach ($actions as $action)
                <a
                    href="{{ $action['url'] }}"
                    class="group flex flex-col items-center justify-center p-4 rounded-xl
                           {{ $action['bg_color'] }}
                           border-2 border-transparent
                           {{ $action['border_color'] }}
                           transition-all duration-200 hover:shadow-md hover:scale-[1.02]"
                >
                    {{-- Icon --}}
                    <div class="w-12 h-12 rounded-full {{ $action['bg_color'] }} flex items-center justify-center mb-2
                                group-hover:scale-110 transition-transform duration-200">
                        <x-filament::icon
                            icon="{{ $action['icon'] }}"
                            class="w-6 h-6 {{ $action['icon_color'] }}"
                        />
                    </div>

                    {{-- Label --}}
                    <span class="text-sm font-medium text-center {{ $action['text_color'] }} group-hover:font-semibold transition-all duration-200">
                        {{ $action['label'] }}
                    </span>

                    {{-- Subtle arrow indicator --}}
                    <span class="mt-1 text-xs {{ $action['text_color'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        Click to add →
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</x-filament-widgets::widget>
