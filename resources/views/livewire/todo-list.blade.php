<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Flash Message --}}
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Add/Edit Todo Form --}}
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas {{ $editingId ? 'fa-edit' : 'fa-plus' }} me-2"></i>
                        {{ $editingId ? 'Edit Todo' : 'Add New Todo' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $editingId ? 'updateTodo' : 'addTodo' }}">
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                <strong>Title <span class="text-danger">*</span></strong>
                            </label>
                            <input type="text" id="title" wire:model="title"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Enter todo title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas {{ $editingId ? 'fa-save' : 'fa-plus' }} me-1"></i>
                                {{ $editingId ? 'Update Todo' : 'Add Todo' }}
                            </button>

                            @if ($editingId)
                                <button type="button" wire:click="cancelEdit" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>


            <div class="mb-3">
                {{-- search  --}}
                <div class="d-flex justify-content-between">
                    <h3 class="text-start text-primary">My Todo List</h3>
                    <input type="text" wire:model.live.debounce="filter" placeholder="Search todos..."
                        class="search">
                </div>
            </div>


            {{-- Todo List --}}
            @forelse($todos as $todo)
                <div class="card mb-3 shadow-sm border-start border-1">
                    <div class="card-body">
                        <div class="d-flex flex-grow-1">
                            <div>
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                    <input type="checkbox" wire:click="toggleComplete({{ $todo->id }})"
                                        {{ $todo->completed ? 'checked' : '' }} class="form-check-input me-3"
                                        style="transform: scale(1.2);">
                                    <h5
                                        class="card-title mb-0 {{ $todo->completed ? 'text-decoration-line-through text-muted' : '' }}">
                                        {{ $todo->title }}
                                    </h5>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-plus me-1"></i>
                                        Created: {{ $todo->created_at->diffForHumans() }}
                                        @if ($todo->updated_at != $todo->created_at)
                                            <i class="fas fa-edit ms-3 me-1"></i>
                                            Updated: {{ $todo->updated_at->diffForHumans() }}
                                        @endif
                                    </small>
                                </div>

                                <div class="d-flex gap-2">
                                    {{-- edit --}}
                                    @unless ($todo->completed)
                                        <button wire:click="editTodo({{ $todo->id }})"
                                            class="btn btn-sm btn-outline-primary" title="Edit Todo">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endunless
                                    {{-- delete --}}
                                    <button wire:click="deleteTodo({{ $todo->id }})"
                                        wire:confirm="Are you sure you want to delete this todo?"
                                        class="btn btn-sm btn-outline-danger" title="Delete Todo">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <span class="text-success fw-bold">{{ $todo->completed ? 'Complete' : '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- if no todo yet --}}
                <div class="card text-center">
                    <div class="card-body py-5">
                        <div class="text-muted">
                            <i class="fas fa-tasks fa-3x mb-3"></i>
                            <h5>
                                No todos yet. Add your first todo above!
                            </h5>
                        </div>
                    </div>
                </div>
            @endforelse

            {{ $todos->links() }}
        </div>
    </div>
</div>
