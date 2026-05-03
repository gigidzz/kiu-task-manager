<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function dashboard()
    {
        $total   = Task::count();
        $done    = Task::where('status', 'done')->count();
        $pending = Task::where('status', 'pending')->count();
        $overdue = Task::where('status', 'pending')
                       ->whereNotNull('deadline')
                       ->where('deadline', '<', Carbon::today())
                       ->count();

        $upcoming = Task::where('status', 'pending')
                        ->whereNotNull('deadline')
                        ->where('deadline', '>=', Carbon::today())
                        ->orderByRaw('deadline IS NULL, deadline ASC')
                        ->limit(5)
                        ->get();

        return view('dashboard', compact('total', 'done', 'pending', 'overdue', 'upcoming'));
    }

    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('deadline_filter')) {
            if ($request->deadline_filter === 'overdue') {
                $query->where('status', 'pending')
                      ->whereNotNull('deadline')
                      ->where('deadline', '<', Carbon::today());
            } elseif ($request->deadline_filter === 'today') {
                $query->whereDate('deadline', Carbon::today());
            } elseif ($request->deadline_filter === 'this_week') {
                $query->whereBetween('deadline', [Carbon::today(), Carbon::today()->endOfWeek()]);
            }
        }

        $tasks = $query->orderByRaw('deadline IS NULL, deadline ASC')->paginate(10)->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject'     => 'required|string|max:255',
            'status'      => 'required|in:pending,done',
            'priority'    => 'required|in:low,medium,high',
            'deadline'    => 'nullable|date',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject'     => 'required|string|max:255',
            'status'      => 'required|in:pending,done',
            'priority'    => 'required|in:low,medium,high',
            'deadline'    => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function toggleStatus(Task $task)
    {
        $task->status = $task->status === 'done' ? 'pending' : 'done';
        $task->save();

        return response()->json([
            'status' => $task->status,
        ]);
    }
}
