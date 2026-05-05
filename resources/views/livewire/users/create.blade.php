<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-900 shadow-lg rounded-xl">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        Tambah User
    </h2>

    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="store" class="space-y-5">

        <!-- Name -->
        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" wire:model="name"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 dark:bg-gray-800 dark:text-white">
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" wire:model="email"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 dark:bg-gray-800 dark:text-white">
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label class="block text-sm font-medium mb-1">No HP</label>
            <input type="text" wire:model="phone_number"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 dark:bg-gray-800 dark:text-white">
        </div>

        <!-- Asal PT -->
        <div>
            <label class="block text-sm font-medium mb-1">Asal Perguruan Tinggi</label>
            <input type="text" wire:model="asal_perguruan_tinggi"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 dark:bg-gray-800 dark:text-white">
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
            <select wire:model="jenis_kelamin"
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select wire:model="status" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>

        <!-- Role -->
        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select wire:model="role" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">
                <option value="Admin">Pembimbing</option>
                <option value="Mahasiswa">User</option>
            </select>
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <label class="block text-sm font-medium mb-1">Password</label>

            <div class="relative">
                <!-- Input -->
                <input :type="show ? 'text' : 'password'" wire:model="password"
                    class="w-full px-4 py-2 pr-12 border rounded-lg focus:ring focus:ring-blue-200 
                   dark:bg-gray-800 dark:text-white">

                <!-- Toggle Button -->
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 
                   hover:text-gray-700 dark:hover:text-white">

                    <!-- Icon Eye -->
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                       -1.274 4.057-5.065 7-9.542 7
                       -4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <!-- Icon Eye Off -->
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19
                       c-4.478 0-8.268-2.943-9.543-7
                       a9.956 9.956 0 012.223-3.592M6.223 6.223
                       A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.543 7
                       a9.965 9.965 0 01-4.132 5.411M15 12a3 3 0 00-3-3
                       m0 0a3 3 0 00-3 3m3-3v6m0 0l-3-3m3 3l3-3" />
                    </svg>
                </button>
            </div>

            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Button -->
        <div class="flex justify-end gap-3">

            <!-- Cancel -->
            <a href="{{ route('users.index') }}" wire:navigate
                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition
               dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                Batal
            </a>

            <!-- Submit -->
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Simpan
            </button>

        </div>

    </form>
</div>
