<div class="">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-ui.stat-card title="Tugas Tersedia" value="{{ $available }}">
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5h6m-7 3h8m-8 4h8m-9 7h10a2 2 0 002-2V7a2 2 0 00-2-2h-1V3H8v2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </x-slot>
        </x-ui.stat-card>
        <!-- AVAILABLE -->
        <x-ui.stat-card title="Tugas Berlangsung" value="{{ $inProgress }}" color="blue">
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot>
        </x-ui.stat-card>
        <x-ui.stat-card title="Tugas Selesai" value="{{ $completed }}" color="purple">
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </x-slot>
        </x-ui.stat-card>

    </div>

</div>
