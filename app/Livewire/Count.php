<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;

class Count extends Component
{
    public $totalTodos;
    public $totalCompleted;
    public $totalIncomplete;

    // public function mount($totalTodos, $totalCompleted, $totalIncomplete){
    //     $this->totalCompleted = $totalCompleted;
    //     $this->totalIncomplete = $totalIncomplete;
    //     $this->totalTodos = $totalTodos;
    // }


    
// listen to the dispatch event 
    protected $listeners = ['todoCountsUpdated' => 'updateCounts'];
    
    public function updateCounts($totalTodos, $totalCompleted, $totalIncomplete)
    {
        $this->totalTodos = $totalTodos;
        $this->totalCompleted = $totalCompleted;
        $this->totalIncomplete = $totalIncomplete;
    }
    public function render()
    {
        return view('livewire.count');
    }
}
