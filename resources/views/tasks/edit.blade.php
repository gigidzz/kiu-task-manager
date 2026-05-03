@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="mb-0 fw-bold">Edit Task</h2>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('tasks._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-floppy me-1"></i>Update Task
                        </button>
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
