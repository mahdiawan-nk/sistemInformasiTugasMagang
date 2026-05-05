<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">

            <!-- decorative gradient -->
            <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-emerald-100 blur-3xl opacity-60"></div>
            <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-blue-100 blur-3xl opacity-60"></div>

            <div class="relative flex items-center justify-between">

                <div>
                    <h2 class="text-xl font-semibold text-gray-900">
                        Selamat Datang 👋
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Selamat bekerja kembali, semoga harimu menyenangkan.
                    </p>

                    <div class="flex items-center gap-4 mt-4 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <circle cx="12" cy="12" r="9" stroke-width="2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7v5l3 3" />
                            </svg>
                            <span>{{ now()->format('l, d F Y') }}</span>
                        </div>

                    </div>
                </div>

                <!-- right illustration -->
                <div
                    class="hidden md:flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                </div>

            </div>
        </div>
        <livewire:dashboard />
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            <x-ui.stat-card title="Tugas Tersedia" value="12">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5h6m-7 3h8m-8 4h8m-9 7h10a2 2 0 002-2V7a2 2 0 00-2-2h-1V3H8v2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </x-slot>
            </x-ui.stat-card>
            <x-ui.stat-card title="Tugas Berlangsung" value="1" color="blue">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot>
            </x-ui.stat-card>
            <x-ui.stat-card title="Tugas Selesai" value="89" color="purple">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </x-slot>
            </x-ui.stat-card>
        </div> --}}

    </div>
</x-layouts.app>
