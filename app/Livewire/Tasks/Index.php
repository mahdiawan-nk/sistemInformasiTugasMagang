<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Task;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $confirmingSubmit = false;
    public $taskToSubmit = null;
    public $submissionFile;

    public $search = '';
    public $status = '';
    public $perPage = 10;

    public $confirmingDelete = false;
    public $taskIdToDelete = null;

    public $confirmingClaim = false;
    public $taskToClaim = null;

    public $confirmingEvaluate = false;
    public $taskToEvaluate = null;

    public $finalPoint;
    public $evaluationNotes;

    public $showingDetail = false;
    public $taskDetail = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function show($id)
    {
        $this->taskDetail = Task::with('student')->findOrFail($id);
        $this->showingDetail = true;
    }

    public function closeDetailModal()
    {
        $this->showingDetail = false;
        $this->taskDetail = null;
    }

    public function confirmDelete($id)
    {
        $this->taskIdToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        $task = Task::findOrFail($this->taskIdToDelete);

        // 🔒 Guard: hanya bisa hapus jika available
        if ($task->status !== 'available') {
            session()->flash('error', 'Task tidak bisa dihapus karena sudah digunakan');
            $this->closeModal();
            return;
        }

        $task->delete();

        session()->flash('success', 'Task berhasil dihapus');

        $this->closeModal();
    }

    public function closeModal()
    {
        $this->confirmingDelete = false;
        $this->taskIdToDelete = null;
    }

    public function confirmClaim($id)
    {
        $task = Task::findOrFail($id);

        // 🔒 Guard
        if ($task->status !== 'available') {
            session()->flash('error', 'Task tidak tersedia');
            return;
        }

        $this->taskToClaim = $task;
        $this->confirmingClaim = true;
    }

    public function claim()
    {
        $task = Task::findOrFail($this->taskToClaim->id);

        // 🔒 Guard ulang
        if ($task->status !== 'available') {
            session()->flash('error', 'Task sudah diambil');
            $this->closeClaimModal();
            return;
        }

        $task->claimBy(auth()->user());

        session()->flash('success', 'Task berhasil diambil');

        $this->closeClaimModal();
    }

    public function closeClaimModal()
    {
        $this->confirmingClaim = false;
        $this->taskToClaim = null;
    }

    public function confirmSubmit($id)
    {
        $task = Task::findOrFail($id);

        // 🔒 Guard
        if ($task->status !== 'in_progress' || $task->user_id !== auth()->id()) {
            session()->flash('error', 'Task tidak valid untuk disubmit');
            return;
        }

        $this->taskToSubmit = $task;
        $this->confirmingSubmit = true;
    }

    public function submitTask()
    {
        $task = Task::findOrFail($this->taskToSubmit->id);

        // 🔒 Guard ulang
        if ($task->status !== 'in_progress' || $task->user_id !== auth()->id()) {
            session()->flash('error', 'Task tidak valid');
            $this->closeSubmitModal();
            return;
        }

        $this->validate([
            'submissionFile' => 'required|file|max:5120|mimes:pdf,doc,docx,zip,rar',
        ]);

        // Upload file
        $path = $this->submissionFile->store('submissions', 'public');

        $task->submit($path);

        session()->flash('success', 'Task berhasil disubmit');

        $this->reset('submissionFile');
        $this->closeSubmitModal();
    }

    public function closeSubmitModal()
    {
        $this->confirmingSubmit = false;
        $this->taskToSubmit = null;
        $this->reset('submissionFile');
    }

    public function confirmEvaluate($id)
    {
        $task = Task::findOrFail($id);

        // 🔒 Guard
        if ($task->status !== 'submitted') {
            session()->flash('error', 'Task belum siap untuk dievaluasi');
            return;
        }

        $this->taskToEvaluate = $task;
        $this->finalPoint = $task->point; // default point awal
        $this->evaluationNotes = null;

        $this->confirmingEvaluate = true;
    }

    public function evaluateTask()
    {
        $task = Task::findOrFail($this->taskToEvaluate->id);

        // 🔒 Guard ulang
        if ($task->status !== 'submitted') {
            session()->flash('error', 'Task tidak valid untuk evaluasi');
            $this->closeEvaluateModal();
            return;
        }

        $this->validate([
            'finalPoint' => 'required|integer|min:0',
            'evaluationNotes' => 'nullable|string|max:1000',
        ]);

        $task->evaluate($this->finalPoint, $this->evaluationNotes);

        session()->flash('success', 'Task berhasil dievaluasi');

        $this->closeEvaluateModal();
    }

    public function closeEvaluateModal()
    {
        $this->confirmingEvaluate = false;
        $this->taskToEvaluate = null;
        $this->reset(['finalPoint', 'evaluationNotes']);
    }
    public function render()
    {
        $user = auth()->user();

        $tasks = Task::query()

            // 🔒 FILTER BERDASARKAN ROLE
            ->when(strtolower($user->role) === 'mahasiswa', function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('status', 'available') // bisa lihat semua yang tersedia
                        ->orWhere('user_id', $user->id); // atau task miliknya
                });
            })

            // 🔍 SEARCH
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })

            // 🎯 FILTER STATUS
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })

            ->latest()
            ->paginate($this->perPage);

        return view('livewire.tasks.index', [
            'tasks' => $tasks
        ]);
    }
}