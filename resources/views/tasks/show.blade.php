@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="mb-0 fw-bold">Task Details</h2>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">{{ $task->title }}</h5>
                @if($task->isDone())
                    <span class="badge bg-success fs-6">Done</span>
                @else
                    <span class="badge bg-secondary fs-6">Pending</span>
                @endif
            </div>
            <div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-3 text-muted">Description</dt>
                    <dd class="col-sm-9">{{ $task->description ?: '—' }}</dd>

                    <dt class="col-sm-3 text-muted">Subject</dt>
                    <dd class="col-sm-9"><span class="badge bg-secondary">{{ $task->subject }}</span></dd>

                    <dt class="col-sm-3 text-muted">Priority</dt>
                    <dd class="col-sm-9">
                        <span class="{{ $task->priorityClass() }}">
                            {{ $task->priorityLabel() }}
                        </span>
                    </dd>

                    <dt class="col-sm-3 text-muted">Deadline</dt>
                    <dd class="col-sm-9">
                        @if($task->deadline)
                            <span class="{{ $task->isPending() && $task->deadline->isPast() ? 'deadline-overdue' : '' }}">
                                {{ $task->deadline->format('d M Y') }}
                                @if($task->isPending() && $task->deadline->isPast())
                                    <span class="badge bg-danger ms-1">Overdue</span>
                                @endif
                            </span>
                        @else
                            —
                        @endif
                    </dd>

                    <dt class="col-sm-3 text-muted">Tags</dt>
                    <dd class="col-sm-9">
                        @forelse($task->tags as $tag)
                            <span class="badge" style="background: {{ $tag->color }};">{{ $tag->name }}</span>
                        @empty
                            <span class="text-muted">—</span>
                        @endforelse
                    </dd>

                    <dt class="col-sm-3 text-muted">Attachment</dt>
                    <dd class="col-sm-9">
                        @if($task->attachment)
                            @php $ext = strtolower(pathinfo($task->attachment, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                                <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $task->attachment) }}" alt="Attachment"
                                         class="img-thumbnail" style="max-height: 160px;">
                                </a>
                            @else
                                <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank">
                                    <i class="bi bi-file-earmark-pdf me-1"></i>View attached file
                                </a>
                            @endif
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3 text-muted">Created</dt>
                    <dd class="col-sm-9">{{ $task->created_at->format('d M Y, H:i') }}</dd>

                    <dt class="col-sm-3 text-muted">Updated</dt>
                    <dd class="col-sm-9">{{ $task->updated_at->format('d M Y, H:i') }}</dd>
                </dl>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                      onsubmit="return confirm('Delete this task?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">
                        <i class="bi bi-trash me-1"></i>Delete
                    </button>
                </form>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary ms-auto">
                    <i class="bi bi-list-ul me-1"></i>All Tasks
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
