{{-- display counts --}}
<div class="d-flex justify-content-evenly flex-wrap">
    <div class="card text-white bg-primary mb-3" style="max-width: 18rem; min-width: 10rem;">
        <div class="card-body">
            <h5 class="card-title">Total Task</h5>
            <p class="card-text">{{ $totalTodos }}</p>
        </div>
    </div>

    <div class="card text-white bg-success mb-3" style="max-width: 18rem; min-width: 10rem;">
        <div class="card-body">
            <h5 class="card-title">Completed Task</h5>
            <p class="card-text">{{ $totalCompleted }}</p>
        </div>
    </div>

    <div class="card text-white bg-warning mb-3" style="max-width: 18rem; min-width: 10rem;">
        <div class="card-body">
            <h5 class="card-title">Remaining Task</h5>
            <p class="card-text">{{ $totalIncomplete }}</p>
        </div>
    </div>
</div>
