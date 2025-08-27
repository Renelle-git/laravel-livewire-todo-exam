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

    public $filter='';

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
    }

    public function deleteTodo($id)
    {
        Todo::findOrFail($id)->delete();
        session()->flash('message', 'Todo deleted successfully!');
    }

    public function render()
    {
        if($this->filter){
            $todos = Todo::where('title', 'LIKE', "%{$this->filter}%")->simplePaginate(5);
            return view('livewire.todo-list', compact('todos'));
        }
        
        $todos = Todo::simplePaginate(5);
        return view('livewire.todo-list', compact('todos'));
    }
}
