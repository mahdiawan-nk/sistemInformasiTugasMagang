<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Task;

#[Layout('layouts.app')]
class Create extends Component
{
    public $title;
    public $description;
    public $point;
    public $deadline_post;

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

    public function store()
    {
        $this->validate();

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'point' => $this->point,
            'deadline_post' => $this->deadline_post,
            'status' => 'available',
        ]);

        session()->flash('success', 'Task berhasil dibuat');

        return redirect()->route('tasks.index');
    }

    public function render()
    {
        return view('livewire.tasks.create');
    }
}