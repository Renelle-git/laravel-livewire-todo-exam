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

    // add todo
    public function addTodo()
    {
        $this->validate();

        Todo::create([
            'title' => $this->title,
        ]);

        $this->reset(['title']);
        $this->todoCounts();//calling todoCounts function to update the counts 
        session()->flash('message', 'Todo added successfully!');
    }
    
    // edit todo
    public function editTodo($id)
    {
        $todo = Todo::findOrFail($id);
        $this->editingId = $id;
        $this->title = $todo->title;
    }

    // update todo
    public function updateTodo()
    {
        $this->validate();

        $todo = Todo::findOrFail($this->editingId);
        $todo->update([
            'title' => $this->title,
        ]);

        $this->reset(['title', 'editingId']);
        $this->todoCounts(); //calling todoCounts function to update the counts 

        session()->flash('message', 'Todo updated successfully!');
    }

    // cancel edit
    public function cancelEdit()
    {
        $this->reset(['title', 'editingId']);
    }

    //toggle the checkbox if the todo is completed
    public function toggleComplete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update(['completed' => !$todo->completed]);
        $this->todoCounts();//calling todoCounts function to update the counts 
    }

    // delete todos
    public function deleteTodo($id)
    {
        Todo::findOrFail($id)->delete();
        $this->todoCounts(); //calling todoCounts function to update the counts 
        session()->flash('message', 'Todo deleted successfully!');
    }

    // mounting the todoCounts to the parent component to be able to update
    public function mount()
    {
        $this->todoCounts();
    }

    // get the counts of todosx completed todos,and incomplete todo
    public function todoCounts()
    {
        $this->totalTodos = Todo::whereNotNull('title')->count();
        $this->totalCompleted = Todo::where('completed', 1)->count();
        $this->totalIncomplete = Todo::where('completed', 0)->count();
        // dispatching and event so the other component can listen to able pass a data from different component
        $this->dispatch('todoCountsUpdated', $this->totalTodos, $this->totalCompleted, $this->totalIncomplete);
    }

    public function render()
    {
        // filter searches
        if ($this->filter) {
            $todos = Todo::where('title', 'LIKE', "%{$this->filter}%")->simplePaginate(5);
            return view('livewire.todo-list', compact('todos'));
        }
        // display todos
        $todos = Todo::simplePaginate(5);
        return view('livewire.todo-list', compact('todos'));
    }
}
