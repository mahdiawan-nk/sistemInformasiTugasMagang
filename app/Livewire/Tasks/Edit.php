<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Task;

#[Layout('layouts.app')]
class Edit extends Component
{
    public Task $task;

    public $title;
    public $description;
    public $point;
    public $deadline_post;

    public function mount(Task $task)
    {
        // 🔒 Guard: hanya bisa edit jika available
        if ($task->status !== 'available') {
            session()->flash('error', 'Task tidak bisa diedit karena sudah digunakan');
            return redirect()->route('tasks.index');
        }

        $this->task = $task;

        // Prefill form
        $this->title = $task->title;
        $this->description = $task->description;
        $this->point = $task->point;
        $this->deadline_post = $task->deadline_post->format('Y-m-d');
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'point' => 'required|integer|min:0',
            'deadline_post' => [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . now()->addDays(7)->toDateString(),
            ],
        ];
    }

    public function update()
    {
        // 🔒 Guard ulang (anti bypass)
        if ($this->task->status !== 'available') {
            session()->flash('error', 'Task tidak bisa diedit');
            return redirect()->route('tasks.index');
        }

        $this->validate();

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'point' => $this->point,
            'deadline_post' => $this->deadline_post,
        ]);

        session()->flash('success', 'Task berhasil diperbarui');

        return redirect()->route('tasks.index');
    }

    public function render()
    {
        return view('livewire.tasks.edit');
    }
}