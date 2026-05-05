<div class="max-w-3xl mx-auto p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Tambah Task</h1>
        <p class="text-sm text-gray-500">Buat task baru untuk mahasiswa magang</p>
    </div>

    <!-- ALERT -->
    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- FORM -->
    <form wire:submit.prevent="store" class="space-y-5 bg-white p-6 rounded-xl shadow">

        <!-- TITLE -->
        <div>
            <label class="block text-sm font-medium mb-1">Judul Task</label>
            <input type="text" wire:model.defer="title"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            @error('title')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- DESCRIPTION -->
        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea wire:model.defer="description" rows="4"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
            @error('description')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- POINT -->
        <div>
            <label class="block text-sm font-medium mb-1">Point</label>
            <input type="number" wire:model.defer="point"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            @error('point')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- DEADLINE -->
        <div>
            <label class="block text-sm font-medium mb-1">
                Deadline (max 7 hari dari sekarang)
            </label>
            <input type="date" wire:model.defer="deadline_post"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            @error('deadline_post')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- ACTION -->
        <div class="flex justify-end gap-2 pt-4">
            <a href="{{ route('tasks.index') }}" class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100">
                Batal
            </a>

            <button type="submit"
                class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                Simpan Task
            </button>
        </div>

    </form>
</div>
