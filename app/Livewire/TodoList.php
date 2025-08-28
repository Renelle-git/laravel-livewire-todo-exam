<?php
// fething data from database
namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    // Counts
    public $totalTodos;
    public $totalCompleted;
    public $totalIncomplete;


    public $filter = '';

    #[Rule('required|min:3|max:255')]
    public $title = '';

    public $editingId = null;

    public function addTodo()
    {
        $this->validate();

        Todo::create([
            'title' => $this->title,
        ]);

        $this->reset(['title']);
        $this->todoCounts();
        session()->flash('message', 'Todo added successfully!');
    }

    public function editTodo($id)
    {
        $todo = Todo::findOrFail($id);
        $this->editingId = $id;
        $this->title = $todo->title;
    }

    public function updateTodo()
    {
        $this->validate();

        $todo = Todo::findOrFail($this->editingId);
        $todo->update([
            'title' => $this->title,
        ]);

        $this->reset(['title']);
        $this->todoCounts();

        session()->flash('message', 'Todo updated successfully!');
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'editingId']);
    }

    public function toggleComplete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update(['completed' => !$todo->completed]);
        $this->todoCounts();
    }

    public function deleteTodo($id)
    {
        Todo::findOrFail($id)->delete();
        $this->todoCounts();
        session()->flash('message', 'Todo deleted successfully!');
    }

    public function mount()
    {
        $this->todoCounts();
    }

    public function todoCounts()
    {
        $this->totalTodos = Todo::whereNotNull('title')->count();
        $this->totalCompleted = Todo::where('completed', 1)->count();
        $this->totalIncomplete = Todo::where('completed', 0)->count();

        $this->dispatch('todoCountsUpdated', $this->totalTodos, $this->totalCompleted, $this->totalIncomplete);
    }

    public function render()
    {
        if ($this->filter) {
            $todos = Todo::where('title', 'LIKE', "%{$this->filter}%")->simplePaginate(5);
            return view('livewire.todo-list', compact('todos'));
        }

        $todos = Todo::simplePaginate(5);
        return view('livewire.todo-list', compact('todos'));
    }
}
