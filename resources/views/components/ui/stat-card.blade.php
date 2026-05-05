@props([
    'title' => 'Title',
    'value' => 0,
    'color' => 'green',
    'subtitle' => null,
])

@php
    $colors = [
        'green' => 'from-emerald-500 to-green-600',
        'blue' => 'from-blue-500 to-indigo-600',
        'purple' => 'from-purple-500 to-pink-600',
        'amber' => 'from-amber-500 to-orange-600',
        'red' => 'from-red-500 to-rose-600',
        'gray' => 'from-gray-500 to-gray-700',
    ];

    $gradient = $colors[$color] ?? $colors['green'];
@endphp

<div x-data="{
    count: 0,
    target: {{ (int) $value }},
    start() {
        let duration = 800
        let step = this.target / (duration / 16)

        let i = setInterval(() => {
            this.count += step
            if (this.count >= this.target) {
                this.count = this.target
                clearInterval(i)
            }
        }, 16)
    }
}" x-init="start()"
    {{ $attributes->merge([
        'class' => 'relative overflow-hidden rounded-2xl p-5 text-white shadow-sm hover:shadow-lg transition-all',
    ]) }}>

    <!-- gradient background -->
    <div class="absolute inset-0 bg-gradient-to-br {{ $gradient }}"></div>

    <!-- glow -->
    <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>

    <div class="relative flex items-start justify-between">

        <div>
            <p class="text-white/80 text-xl font-bold tracking-tight">
                {{ $title }}
            </p>

            <h3 class="text-3xl font-bold mt-1 tracking-tight">
                <span x-text="Math.floor(count)"></span>
            </h3>

            @if ($subtitle)
                <p class="text-xs text-white/70 mt-1">
                    {{ $subtitle }}
                </p>
            @endif
        </div>

        @isset($icon)
            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                {{ $icon }}
            </div>
        @endisset

    </div>

</div>
