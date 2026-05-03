@extends('layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-5">
    <div class="page-title">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }} 👋</div>
    <div class="page-subtitle">Here's where your tasks stand today, {{ now()->format('l, d F') }}.</div>
</div>

{{-- Stat Strip --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card px-4 py-3">
            <div style="font-size: 2.4rem; font-weight: 800; line-height: 1; color: #1e2a3a;">{{ $total }}</div>
            <div class="mt-1" style="font-size: .8rem; color: #8693a4; font-weight: 500; text-transform: uppercase; letter-spacing: .6px;">Total</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card px-4 py-3">
            <div style="font-size: 2.4rem; font-weight: 800; line-height: 1; color: #065f46;">{{ $done }}</div>
            <div class="mt-1" style="font-size: .8rem; color: #8693a4; font-weight: 500; text-transform: uppercase; letter-spacing: .6px;">Done</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card px-4 py-3">
            <div style="font-size: 2.4rem; font-weight: 800; line-height: 1; color: #4f8ef7;">{{ $pending }}</div>
            <div class="mt-1" style="font-size: .8rem; color: #8693a4; font-weight: 500; text-transform: uppercase; letter-spacing: .6px;">Pending</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card px-4 py-3" style="{{ $overdue > 0 ? 'border-color: #fca5a5;' : '' }}">
            <div style="font-size: 2.4rem; font-weight: 800; line-height: 1; color: {{ $overdue > 0 ? '#e53e3e' : '#1e2a3a' }};">{{ $overdue }}</div>
            <div class="mt-1" style="font-size: .8rem; color: #8693a4; font-weight: 500; text-transform: uppercase; letter-spacing: .6px;">Overdue</div>
        </div>
    </div>
</div>

{{-- Progress --}}
@if($total > 0)
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span style="font-size: .85rem; font-weight: 600; color: #4a5568;">Completion</span>
        <span style="font-size: .85rem; color: #8693a4;">{{ $done }}/{{ $total }} tasks</span>
    </div>
    <div class="progress" style="height: 8px; border-radius: 99px; background: #e8eaed;">
        <div class="progress-bar" style="width: {{ round($done / $total * 100) }}%; background: #4f8ef7; border-radius: 99px;"></div>
    </div>
    <div class="mt-1 text-end" style="font-size: .78rem; color: #8693a4;">{{ round($done / $total * 100) }}% complete</div>
</div>
@endif

{{-- Overdue alert --}}
@if($overdue > 0)
<div class="d-flex align-items-center gap-3 px-4 py-3 mb-4 rounded-3" style="background: #fff5f5; border: 1px solid #fca5a5;">
    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
    <span style="font-size: .875rem;">
        You have <strong>{{ $overdue }} overdue {{ Str::plural('task', $overdue) }}</strong>.
        <a href="{{ route('tasks.index', ['deadline_filter' => 'overdue']) }}" class="text-danger fw-semibold ms-1">View them →</a>
    </span>
</div>
@endif

{{-- Upcoming --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <span style="font-weight: 700; font-size: 1rem; color: #1e2a3a;">Upcoming Deadlines</span>
    <a href="{{ route('tasks.index') }}" style="font-size: .82rem; color: #4f8ef7; text-decoration: none; font-weight: 500;">View all →</a>
</div>

@if($upcoming->isEmpty())
    <div class="card text-center py-5" style="border-style: dashed;">
        <div style="color: #8693a4; font-size: .9rem;">
            <i class="bi bi-calendar-check d-block mb-2" style="font-size: 1.8rem;"></i>
            No upcoming tasks — you're all clear!
        </div>
    </div>
@else
    <div class="card overflow-hidden">
        @foreach($upcoming as $i => $task)
        @php $daysLeft = (int) now()->startOfDay()->diffInDays($task->deadline->startOfDay(), false); @endphp
        <div class="d-flex align-items-center justify-content-between px-4 py-3 {{ $i < $upcoming->count() - 1 ? 'border-bottom' : '' }}"
             style="border-color: #f0f1f4;">
            <div>
                <a href="{{ route('tasks.show', $task) }}"
                   style="font-weight: 600; font-size: .9rem; color: #1e2a3a; text-decoration: none;">
                    {{ $task->title }}
                </a>
                <div style="font-size: .78rem; margin-top: 2px; color: #8693a4;">
                    {{ $task->subject }}
                    &nbsp;·&nbsp;
                    <span class="{{ $task->priorityClass() }}">{{ $task->priorityLabel() }}</span>
                </div>
            </div>
            <div class="text-end ms-3" style="white-space: nowrap;">
                <span class="badge rounded-pill
                    {{ $daysLeft === 0 ? 'bg-danger' : ($daysLeft <= 2 ? 'bg-warning text-dark' : 'bg-light text-secondary border') }}"
                    style="font-size: .75rem; font-weight: 600;">
                    {{ $daysLeft === 0 ? 'Today' : ($daysLeft === 1 ? 'Tomorrow' : $daysLeft . ' days') }}
                </span>
                <div style="font-size: .75rem; color: #8693a4; margin-top: 3px;">{{ $task->deadline->format('d M') }}</div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
