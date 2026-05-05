<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Task;

// #[Layout('layouts.app')]
class Dashboard extends Component
{
    public $available;
    public $inProgress;
    public $completed;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->available = Task::where('status', 'available')->count();

        $this->inProgress = Task::whereIn('status', [
            'in_progress',
            'submitted'
        ])->count();

        $this->completed = Task::where('status', 'done')->count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}