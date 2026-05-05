<div class="p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Tasks</h1>
            <p class="text-sm text-gray-500">Kelola semua tasks</p>
        </div>
        @if (strtolower(auth()->user()->role) === 'admin')
            <a href="{{ route('tasks.create') }}" wire:navigate
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">

                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10 5a.75.75 0 0 1 .75.75v3.5h3.5a.75.75 0 0 1 0 1.5h-3.5v3.5a.75.75 0 0 1-1.5 0v-3.5h-3.5a.75.75 0 0 1 0-1.5h3.5v-3.5A.75.75 0 0 1 10 5Z" />
                </svg>

                Add Task
            </a>
        @endif
    </div>
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6 mt-6">

        <div class="flex gap-2">
            <!-- SEARCH -->
            <input type="text" wire:model.live="search" placeholder="Cari task..."
                class="border rounded-lg px-3 py-2 text-sm w-64">

            <!-- FILTER STATUS -->

        </div>
        <select wire:model.live="status" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">Semua Status</option>
            <option value="available">Tersedia</option>
            <option value="in_progress">Dikerjakan</option>
            <option value="submitted">Menunggu Review</option>
            <option value="done">Selesai</option>
        </select>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Point</th>
                    <th class="p-3">Mahasiswa</th>
                    <th class="p-3">Deadline</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-medium">
                            {{ $task->title }}
                            <div class="text-xs text-gray-500">
                                {{ Str::limit($task->description, 50) }}
                            </div>
                        </td>

                        <td class="p-3">
                            {{ $task->point }}
                        </td>

                        <td class="p-3">
                            {{ $task->student?->name ?? '-' }}
                            <span class="block text-xs text-gray-500">{{ $task->student?->asal_perguruan_tinggi ?? '-' }}</span>
                        </td>

                        <td class="p-3">
                            @if ($task->deadline_taken)
                                {{ $task->deadline_taken->format('d M Y') }}
                            @else
                                {{ $task->deadline_post->format('d M Y') }}
                            @endif
                        </td>

                        <!-- STATUS BADGE -->
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded text-xs font-semibold
                                @if ($task->status == 'available') bg-gray-200 text-gray-700
                                @elseif($task->status == 'in_progress') bg-blue-100 text-blue-700
                                @elseif($task->status == 'submitted') bg-yellow-100 text-yellow-700
                                @elseif($task->status == 'done') bg-green-100 text-green-700 @endif
                            ">
                                {{ $task->status_label }}
                            </span>
                        </td>

                        <!-- ACTION -->
                        <td class="p-3 text-center">
                            <div class="flex flex-wrap justify-center gap-1.5">

                                {{-- ================= ADMIN ================= --}}
                                @if (strtolower(auth()->user()->role) === 'admin')
                                    <!-- DETAIL -->
                                    <button wire:click="show({{ $task->id }})"
                                        class="px-2 py-1 text-xs rounded-md border border-blue-200 text-blue-600 hover:bg-blue-50 transition">
                                        👁 Detail
                                    </button>

                                    <!-- EDIT -->
                                    @if ($task->status === 'available')
                                        <a href="{{ route('tasks.edit', $task->id) }}" wire:navigate
                                            class="px-2 py-1 text-xs rounded-md border border-yellow-200 text-yellow-600 hover:bg-yellow-50 transition">
                                            ✏️ Edit
                                        </a>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
                                            ✏️ Edit
                                        </span>
                                    @endif

                                    <!-- DELETE -->
                                    @if ($task->status === 'available')
                                        <button wire:click="confirmDelete({{ $task->id }})"
                                            class="px-2 py-1 text-xs rounded-md border border-red-200 text-red-600 hover:bg-red-50 transition">
                                            🗑 Hapus
                                        </button>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
                                            🗑 Hapus
                                        </span>
                                    @endif

                                    <!-- EVALUASI -->
                                    @if ($task->status === 'submitted')
                                        <button wire:click="confirmEvaluate({{ $task->id }})"
                                            class="px-2 py-1 text-xs rounded-md bg-green-600 text-white hover:bg-green-700 transition shadow-sm">
                                            ✔ Evaluasi
                                        </button>
                                    @elseif($task->status === 'in_progress')
                                        <span class="px-2 py-1 text-xs rounded-md bg-yellow-100 text-yellow-700">
                                            ⏳ Menunggu
                                        </span>
                                    @elseif($task->status === 'done')
                                        <span
                                            class="px-2 py-1 text-xs rounded-md bg-green-100 text-green-700 font-medium">
                                            ✔ Dinilai
                                        </span>
                                    @endif
                                @endif


                                {{-- ================= MAHASISWA ================= --}}
                                @if (strtolower(auth()->user()->role) === 'mahasiswa')
                                    <!-- AMBIL TASK -->
                                    @if ($task->status === 'available')
                                        <button wire:click="confirmClaim({{ $task->id }})"
                                            class="px-2 py-1 text-xs rounded-md bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                                            📥 Ambil
                                        </button>
                                    @endif

                                    <!-- SUBMIT TASK -->
                                    @if ($task->status === 'in_progress' && $task->user_id === auth()->id())
                                        <button wire:click="confirmSubmit({{ $task->id }})"
                                            class="px-2 py-1 text-xs rounded-md bg-green-600 text-white hover:bg-green-700 transition shadow-sm">
                                            ⬆ Submit
                                        </button>
                                    @endif

                                    <!-- DETAIL -->
                                    @if ($task->user_id === auth()->id())
                                        <button wire:click="show({{ $task->id }})"
                                            class="px-2 py-1 text-xs rounded-md border border-blue-200 text-blue-600 hover:bg-blue-50 transition">
                                            👁 Detail
                                        </button>
                                    @endif
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-6 text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $tasks->links() }}
    </div>

    @if ($confirmingDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">

                <!-- TITLE -->
                <h2 class="text-lg font-semibold mb-2">Konfirmasi Hapus</h2>

                <!-- CONTENT -->
                <p class="text-sm text-gray-600 mb-6">
                    Apakah kamu yakin ingin menghapus task ini?
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <!-- ACTION -->
                <div class="flex justify-end gap-2">

                    <button wire:click="closeModal" class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100">
                        Batal
                    </button>

                    <button wire:click="delete"
                        class="px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                        Ya, Hapus
                    </button>

                </div>
            </div>
        </div>
    @endif

    @if ($confirmingClaim && $taskToClaim)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">

                <!-- TITLE -->
                <h2 class="text-lg font-semibold mb-4">
                    Konfirmasi Ambil Task
                </h2>

                <!-- SUMMARY -->
                <div class="border rounded-lg p-4 mb-5 bg-gray-50 text-sm space-y-2">

                    <div>
                        <span class="font-medium">Judul:</span>
                        <div class="text-gray-700">{{ $taskToClaim->title }}</div>
                    </div>

                    <div>
                        <span class="font-medium">Deskripsi:</span>
                        <div class="text-gray-600 text-xs">
                            {{ \Illuminate\Support\Str::limit($taskToClaim->description, 120) }}
                        </div>
                    </div>

                    <div class="flex justify-between text-xs mt-2">
                        <div>
                            <span class="font-medium">Point:</span>
                            <span class="text-blue-600">{{ $taskToClaim->point }}</span>
                        </div>

                        <div>
                            <span class="font-medium">Deadline:</span>
                            <span class="text-red-500">
                                {{ $taskToClaim->deadline_post->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                </div>

                <!-- WARNING -->
                <div class="text-xs text-yellow-600 mb-5">
                    ⚠️ Setelah mengambil task, kamu memiliki waktu 7 hari untuk menyelesaikannya.
                </div>

                <!-- ACTION -->
                <div class="flex justify-end gap-2">

                    <button wire:click="closeClaimModal" class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100">
                        Batal
                    </button>

                    <button wire:click="claim" wire:loading.attr="disabled"
                        class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">

                        <span wire:loading.remove>Ya, Ambil Task</span>
                        <span wire:loading>Processing...</span>

                    </button>

                </div>
            </div>
        </div>
    @endif
    @if ($confirmingSubmit && $taskToSubmit)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">

                <!-- TITLE -->
                <h2 class="text-lg font-semibold mb-4">
                    Submit Task
                </h2>

                <!-- SUMMARY -->
                <div class="border rounded-lg p-4 mb-5 bg-gray-50 text-sm space-y-2">

                    <div>
                        <span class="font-medium">Judul:</span>
                        <div>{{ $taskToSubmit->title }}</div>
                    </div>

                    <div class="flex justify-between text-xs">
                        <div>
                            <span class="font-medium">Point:</span>
                            <span class="text-blue-600">{{ $taskToSubmit->point }}</span>
                        </div>

                        <div>
                            <span class="font-medium">Deadline:</span>
                            <span class="text-red-500">
                                {{ $taskToSubmit->deadline_taken->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                </div>

                <!-- FILE UPLOAD -->
                <div class="mb-5">
                    <label class="block text-sm font-medium mb-1">
                        Upload File
                    </label>

                    <input type="file" wire:model="submissionFile"
                        class="w-full border rounded-lg px-3 py-2 text-sm">

                    @error('submissionFile')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror

                    <div wire:loading wire:target="submissionFile" class="text-xs text-blue-500 mt-1">
                        Uploading...
                    </div>
                </div>

                <!-- INFO -->
                <div class="text-xs text-gray-500 mb-4">
                    Format: PDF, DOC, DOCX, ZIP (Max 2MB)
                </div>

                <!-- ACTION -->
                <div class="flex justify-end gap-2">

                    <button wire:click="closeSubmitModal"
                        class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100">
                        Batal
                    </button>

                    <button wire:click="submitTask" wire:loading.attr="disabled"
                        class="px-4 py-2 text-sm rounded-lg bg-green-600 text-white hover:bg-green-700 transition">

                        <span wire:loading.remove>Submit Task</span>
                        <span wire:loading>Processing...</span>

                    </button>

                </div>

            </div>
        </div>
    @endif

    @if ($confirmingEvaluate && $taskToEvaluate)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">

                <!-- TITLE -->
                <h2 class="text-lg font-semibold mb-4">
                    Evaluasi Task
                </h2>

                <!-- SUMMARY -->
                <div class="border rounded-lg p-4 mb-5 bg-gray-50 text-sm space-y-2">

                    <div>
                        <span class="font-medium">Judul:</span>
                        <div>{{ $taskToEvaluate->title }}</div>
                    </div>

                    <div>
                        <span class="font-medium">Mahasiswa:</span>
                        <div class="text-gray-600 text-xs">
                            {{ $taskToEvaluate->student?->name ?? '-' }}
                        </div>
                    </div>

                    <div class="flex justify-between text-xs">
                        <div>
                            <span class="font-medium">Point Awal:</span>
                            <span class="text-blue-600">{{ $taskToEvaluate->point }}</span>
                        </div>

                        <div>
                            <span class="font-medium">Deadline:</span>
                            <span class="text-red-500">
                                {{ $taskToEvaluate->deadline_taken->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- FILE -->
                    @if ($taskToEvaluate->submission_file)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $taskToEvaluate->submission_file) }}" target="_blank"
                                class="text-blue-600 text-xs underline">
                                📄 Lihat File Submission
                            </a>
                        </div>
                    @endif

                </div>

                <!-- INPUT NILAI -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Nilai Akhir
                    </label>

                    <input type="number" wire:model.defer="finalPoint"
                        class="w-full border rounded-lg px-3 py-2 text-sm">

                    @error('finalPoint')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- CATATAN -->
                <div class="mb-5">
                    <label class="block text-sm font-medium mb-1">
                        Catatan Evaluasi
                    </label>

                    <textarea wire:model.defer="evaluationNotes" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>

                    @error('evaluationNotes')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ACTION -->
                <div class="flex justify-end gap-2">

                    <button wire:click="closeEvaluateModal"
                        class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100">
                        Batal
                    </button>

                    <button wire:click="evaluateTask" wire:loading.attr="disabled"
                        class="px-4 py-2 text-sm rounded-lg bg-green-600 text-white hover:bg-green-700 transition">

                        <span wire:loading.remove>Simpan & Approve</span>
                        <span wire:loading>Processing...</span>

                    </button>

                </div>

            </div>
        </div>
    @endif

    @if ($showingDetail && $taskDetail)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

            <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">

                <!-- HEADER -->
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-lg font-semibold">Detail Task</h2>
                    <button wire:click="closeDetailModal" class="text-gray-400 hover:text-gray-600 text-sm">
                        ✕
                    </button>
                </div>

                <!-- CONTENT -->
                <div class="space-y-4 text-sm">

                    <!-- TITLE -->
                    <div>
                        <span class="font-medium">Judul</span>
                        <div class="text-gray-700">{{ $taskDetail->title }}</div>
                    </div>

                    <!-- DESCRIPTION -->
                    <div>
                        <span class="font-medium">Deskripsi</span>
                        <div class="text-gray-600 text-xs">
                            {{ $taskDetail->description }}
                        </div>
                    </div>

                    <!-- INFO GRID -->
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <span class="font-medium">Point</span>
                            <div class="text-blue-600 font-semibold">
                                {{ $taskDetail->point }}
                            </div>
                        </div>

                        <div>
                            <span class="font-medium">Status</span>
                            <div>
                                <span
                                    class="px-2 py-1 rounded text-xs font-semibold
                                @if ($taskDetail->status == 'available') bg-gray-200 text-gray-700
                                @elseif($taskDetail->status == 'in_progress') bg-blue-100 text-blue-700
                                @elseif($taskDetail->status == 'submitted') bg-yellow-100 text-yellow-700
                                @elseif($taskDetail->status == 'done') bg-green-100 text-green-700 @endif
                            ">
                                    {{ $taskDetail->status_label }}
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- DEADLINE -->
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <span class="font-medium">Deadline Awal</span>
                            <div class="text-gray-600">
                                {{ $taskDetail->deadline_post->format('d M Y') }}
                            </div>
                        </div>

                        <div>
                            <span class="font-medium">Deadline Pengerjaan</span>
                            <div class="text-gray-600">
                                {{ $taskDetail->deadline_taken?->format('d M Y') ?? '-' }}
                            </div>
                        </div>

                    </div>

                    <!-- MAHASISWA -->
                    <div>
                        <span class="font-medium">Mahasiswa</span>
                        <div class="text-gray-600">
                            {{ $taskDetail->student?->name ?? '-' }}
                        </div>
                    </div>

                    <!-- SUBMISSION -->
                    @if ($taskDetail->submission_file)
                        <div>
                            <span class="font-medium">File Submission</span>
                            <div>
                                <a href="{{ asset('storage/' . $taskDetail->submission_file) }}" target="_blank"
                                    class="text-blue-600 text-xs underline">
                                    📄 Lihat File
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- TANGGAL SUBMIT -->
                    @if ($taskDetail->submission_date)
                        <div>
                            <span class="font-medium">Tanggal Submit</span>
                            <div class="text-gray-600">
                                {{ \Carbon\Carbon::parse($taskDetail->submission_date)->format('d M Y') }}
                            </div>
                        </div>
                    @endif

                    <!-- EVALUASI -->
                    @if ($taskDetail->status === 'done')
                        <div class="border-t pt-4">

                            <h3 class="font-medium mb-2">Evaluasi</h3>

                            <div class="text-sm">
                                <div>
                                    <span class="font-medium">Nilai Akhir:</span>
                                    <span class="text-green-600 font-semibold">
                                        {{ $taskDetail->final_point }}
                                    </span>
                                </div>

                                <div class="mt-2">
                                    <span class="font-medium">Catatan:</span>
                                    <div class="text-gray-600 text-xs">
                                        {{ $taskDetail->evaluation_notes ?? '-' }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif

                </div>

                <!-- FOOTER -->
                <div class="mt-6 flex justify-end">
                    <button wire:click="closeDetailModal"
                        class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
