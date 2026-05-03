@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="page-title">My Tasks</div>
        <div class="page-subtitle">{{ $tasks->total() }} task{{ $tasks->total() !== 1 ? 's' : '' }} found</div>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn-nav-new" style="font-size: .85rem; padding: 8px 18px;">
        + Add Task
    </a>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('tasks.index') }}" id="filter-form" class="mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center">
        {{-- Search --}}
        <div class="position-relative" style="flex: 1; min-width: 180px; max-width: 280px;">
            <i class="bi bi-search position-absolute" style="left: 11px; top: 50%; transform: translateY(-50%); color: #8693a4; font-size: .85rem;"></i>
            <input type="text" name="search" id="search-input"
                   class="form-control form-control-sm ps-4"
                   style="border-radius: 8px; border-color: #e8eaed; font-size: .85rem;"
                   placeholder="Search tasks…"
                   value="{{ request('search') }}">
        </div>

        {{-- Status --}}
        <select name="status" class="form-select form-select-sm auto-filter"
                style="width: auto; border-radius: 8px; border-color: #e8eaed; font-size: .85rem;">
            <option value="">All statuses</option>
            <option value="0" @selected(request('status') === '0')>Pending</option>
            <option value="1" @selected(request('status') === '1')>Done</option>
        </select>

        {{-- Priority --}}
        <select name="priority" class="form-select form-select-sm auto-filter"
                style="width: auto; border-radius: 8px; border-color: #e8eaed; font-size: .85rem;">
            <option value="">All priorities</option>
            <option value="2" @selected(request('priority') === '2')>High priority</option>
            <option value="1" @selected(request('priority') === '1')>Medium priority</option>
            <option value="0" @selected(request('priority') === '0')>Low priority</option>
        </select>

        {{-- Deadline --}}
        <select name="deadline_filter" class="form-select form-select-sm auto-filter"
                style="width: auto; border-radius: 8px; border-color: #e8eaed; font-size: .85rem;">
            <option value="">All deadlines</option>
            <option value="overdue"   @selected(request('deadline_filter') === 'overdue')>Overdue</option>
            <option value="today"     @selected(request('deadline_filter') === 'today')>Due today</option>
            <option value="this_week" @selected(request('deadline_filter') === 'this_week')>Due this week</option>
        </select>

        @if(request()->hasAny(['search', 'status', 'priority', 'deadline_filter']))
            <a href="{{ route('tasks.index') }}"
               style="font-size: .8rem; color: #8693a4; text-decoration: none; white-space: nowrap;">
                ✕ Clear filters
            </a>
        @endif
    </div>
</form>

{{-- Table --}}
@if($tasks->isEmpty())
    <div class="card text-center py-5" style="border-style: dashed;">
        <div style="color: #8693a4; font-size: .9rem;">
            <i class="bi bi-inbox d-block mb-2" style="font-size: 2rem;"></i>
            No tasks match your filters.
            <a href="{{ route('tasks.create') }}" style="color: #4f8ef7; text-decoration: none; font-weight: 600; display: block; margin-top: 8px;">+ Add one</a>
        </div>
    </div>
@else
    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 40px; padding-left: 20px;">#</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th style="width: 110px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    @php $isOverdue = $task->isPending() && $task->deadline && $task->deadline->isPast(); @endphp
                    <tr class="{{ $isOverdue ? 'row-overdue' : '' }}">
                        <td class="ps-4" style="color: #c0c8d4; font-size: .8rem;">{{ $task->id }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task) }}"
                               style="font-weight: 600; font-size: .9rem; text-decoration: none; color: {{ $isOverdue ? '#e53e3e' : '#1e2a3a' }};">
                                {{ $task->title }}
                            </a>
                        </td>
                        <td>
                            <span style="font-size: .75rem; background: #f3f4f6; color: #6b7280; padding: 3px 9px; border-radius: 20px; font-weight: 500;">
                                {{ $task->subject }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm toggle-btn {{ $task->isDone() ? 'btn-success' : 'btn-outline-secondary' }}"
                                    data-url="{{ route('tasks.toggle', $task) }}"
                                    title="Click to toggle">
                                @if($task->isDone())
                                    <i class="bi bi-check-circle-fill me-1"></i>Done
                                @else
                                    <i class="bi bi-circle me-1"></i>Pending
                                @endif
                            </button>
                        </td>
                        <td>
                            <span class="{{ $task->priorityClass() }}" style="font-size: .85rem;">
                                {{ $task->priorityLabel() }}
                            </span>
                        </td>
                        <td style="font-size: .85rem;">
                            @if($task->deadline)
                                <span class="{{ $isOverdue ? 'deadline-overdue' : 'text-muted' }}">
                                    {{ $task->deadline->format('d M Y') }}
                                    @if($isOverdue)
                                        <span style="font-size: .7rem; background: #fee2e2; color: #b91c1c; padding: 2px 7px; border-radius: 20px; font-weight: 600; margin-left: 4px;">overdue</span>
                                    @endif
                                </span>
                            @else
                                <span style="color: #c0c8d4;">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1 justify-content-end pe-2">
                                <a href="{{ route('tasks.show', $task) }}"
                                   style="font-size: .8rem; padding: 4px 10px; border-radius: 6px; background: #f3f4f6; color: #6b7280; text-decoration: none;"
                                   title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('tasks.edit', $task) }}"
                                   style="font-size: .8rem; padding: 4px 10px; border-radius: 6px; background: #fef3c7; color: #92400e; text-decoration: none;"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="font-size: .8rem; padding: 4px 10px; border-radius: 6px; background: #fee2e2; color: #b91c1c; border: none; cursor: pointer;"
                                            title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $tasks->links() }}
    </div>
@endif

<script>
// Auto-submit when any dropdown filter changes
document.querySelectorAll('.auto-filter').forEach(sel => {
    sel.addEventListener('change', () => document.getElementById('filter-form').submit());
});

// Search: submit after user stops typing (400ms debounce)
const searchInput = document.getElementById('search-input');
let searchTimer;
searchInput.addEventListener('input', () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => document.getElementById('filter-form').submit(), 400);
});

// AJAX status toggle
document.querySelectorAll('.toggle-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
        btn.classList.add('spinning');

        const res = await fetch(btn.dataset.url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        });

        if (!res.ok) { btn.classList.remove('spinning'); return; }

        const { status } = await res.json();
        const row = btn.closest('tr');

        if (status === 1) {
            btn.className = 'btn btn-sm toggle-btn btn-success';
            btn.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i>Done';
            row.classList.remove('row-overdue');
            row.querySelectorAll('[style*="fee2e2"]').forEach(el => el.remove());
            const deadlineSpan = row.querySelector('td:nth-child(6) span');
            if (deadlineSpan) deadlineSpan.classList.remove('deadline-overdue');
            const titleLink = row.querySelector('td:nth-child(2) a');
            if (titleLink) titleLink.style.color = '#1e2a3a';
        } else {
            btn.className = 'btn btn-sm toggle-btn btn-outline-secondary';
            btn.innerHTML = '<i class="bi bi-circle me-1"></i>Pending';
        }

        btn.classList.remove('spinning');
    });
});
</script>
@endsection
