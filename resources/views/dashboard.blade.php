@extends('layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-5">
    <div class="page-title">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }} 👋</div>
    <div class="page-subtitle">Here's where your tasks stand today, {{ now()->format('l, d F') }}.</div>
</div>

{{-- Stat Overview: completion ring + legend --}}
@php
    $pct    = $total > 0 ? (int) round($done / $total * 100) : 0;
    $circ   = 314.16;                       // circumference of r=50 ring (2·π·50)
    $offset = $circ * (1 - $pct / 100);     // how much of the ring stays empty
    $legend = [
        ['label' => 'Total',   'value' => $total,   'color' => '#4f8ef7'],
        ['label' => 'Done',    'value' => $done,    'color' => '#10b981'],
        ['label' => 'Pending', 'value' => $pending, 'color' => '#f59e0b'],
        ['label' => 'Overdue', 'value' => $overdue, 'color' => '#ef4444'],
    ];
@endphp
<div class="card mb-4 px-4 py-4" style="border-radius: 16px;">
    <div class="d-flex flex-column flex-sm-row align-items-center gap-4">

        {{-- Completion ring --}}
        <div style="position: relative; width: 120px; height: 120px; flex-shrink: 0;">
            <svg width="120" height="120" viewBox="0 0 120 120">
                <circle cx="60" cy="60" r="50" fill="none" stroke="#eef0f3" stroke-width="12"/>
                <circle cx="60" cy="60" r="50" fill="none" stroke="#4f8ef7" stroke-width="12" stroke-linecap="round"
                        stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $offset }}"
                        transform="rotate(-90 60 60)"/>
            </svg>
            <div style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div style="font-size: 1.7rem; font-weight: 800; line-height: 1; color: #1e2a3a;">{{ $pct }}%</div>
                <div style="font-size: .66rem; color: #8693a4; text-transform: uppercase; letter-spacing: .5px;">complete</div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex-grow-1 w-100">
            <div class="row g-3">
                @foreach($legend as $item)
                <div class="col-6">
                    <div class="d-flex align-items-center gap-2">
                        <span style="width: 9px; height: 9px; border-radius: 50%; background: {{ $item['color'] }}; flex-shrink: 0;"></span>
                        <span style="font-size: 1.4rem; font-weight: 800; color: #1e2a3a; line-height: 1;">{{ $item['value'] }}</span>
                        <span style="font-size: .8rem; color: #8693a4;">{{ $item['label'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

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
