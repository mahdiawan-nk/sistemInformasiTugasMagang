<div class=" space-y-6">

    <!-- header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Manage Users</h1>
            <p class="text-sm text-gray-500">Kelola semua pengguna sistem</p>
        </div>

        <a href="{{ route('users.create') }}" wire:navigate
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">

            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M10 5a.75.75 0 0 1 .75.75v3.5h3.5a.75.75 0 0 1 0 1.5h-3.5v3.5a.75.75 0 0 1-1.5 0v-3.5h-3.5a.75.75 0 0 1 0-1.5h3.5v-3.5A.75.75 0 0 1 10 5Z" />
            </svg>

            Add User
        </a>
    </div>


    <!-- filter -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <!-- search -->
        <div class="relative w-full md:w-72">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute size-4 left-3 top-3 text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="m21 21-4.35-4.35M16.65 10.5a6.15 6.15 0 1 1-12.3 0 6.15 6.15 0 0 1 12.3 0Z" />
            </svg>

            <input type="text" placeholder="Search users..." wire:model.live.debounce.300ms="search"
                class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
        </div>

        <!-- filter role -->
        <select wire:model.live="role"
            class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500">
            <option value="">All Role</option>
            <option value="Admin">Admin</option>
            <option value="Mahasiswa">Mahasiswa</option>
        </select>

    </div>


    <!-- table -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-xl">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Asal PT/SMK</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">

                            <!-- user -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ $user->name }}"
                                        class="w-9 h-9 rounded-full" />

                                    <div>
                                        <div class="font-medium text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- email -->
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>

                            <!-- role -->
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded-lg">
                                    {{ $user->role == 'Admin' ? 'Pembimbing' : 'User' }}
                                </span>
                            </td>

                            <!-- status -->
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium text-emerald-700 bg-emerald-50 rounded-lg">
                                    Active
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->asal_perguruan_tinggi ?? '-' }}
                            </td>

                            <!-- action -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('users.edit', $user->id) }}" wire:navigate
                                        class="px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100">
                                        Edit
                                    </a>
                                    {{-- 
                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-2 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100">
                                            Delete
                                        </button>
                                    </form> --}}

                                </div>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


        <!-- pagination -->
        <div class="px-6 py-4 border-t">
            {{ $users->links() }}
        </div>

    </div>

</div>
