<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function dashboard(Request $request)
    {
        $tasks = $request->user()->tasks();

        $total   = (clone $tasks)->count();
        $done    = (clone $tasks)->where('status', Task::DONE)->count();
        $pending = (clone $tasks)->where('status', Task::PENDING)->count();
        $overdue = (clone $tasks)->where('status', Task::PENDING)
                       ->whereNotNull('deadline')
                       ->where('deadline', '<', Carbon::today())
                       ->count();

        $upcoming = (clone $tasks)->where('status', Task::PENDING)
                        ->whereNotNull('deadline')
                        ->where('deadline', '>=', Carbon::today())
                        ->orderByRaw('deadline IS NULL, deadline ASC')
                        ->limit(5)
                        ->get();

        return view('dashboard', compact('total', 'done', 'pending', 'overdue', 'upcoming'));
    }

    public function index(Request $request)
    {
        $query = $request->user()->tasks()->with('tags');

        if ($request->filled('status')) {
            $query->where('status', (int) $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', (int) $request->priority);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('deadline_filter')) {
            if ($request->deadline_filter === 'overdue') {
                $query->where('status', Task::PENDING)
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
        $tags = Tag::orderBy('name')->get();

        return view('tasks.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject'     => 'required|string|max:255',
            'status'      => 'required|in:0,1',
            'priority'    => 'required|in:0,1,2',
            'deadline'    => 'nullable|date',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $validated['status']   = (int) $validated['status'];
        $validated['priority'] = (int) $validated['priority'];

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $task = $request->user()->tasks()->create($validated);
        $task->tags()->sync($request->input('tags', []));

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $this->authorizeTask($task);

        $task->load('tags');

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorizeTask($task);

        $tags = Tag::orderBy('name')->get();
        $task->load('tags');

        return view('tasks.edit', compact('task', 'tags'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject'     => 'required|string|max:255',
            'status'      => 'required|in:0,1',
            'priority'    => 'required|in:0,1,2',
            'deadline'    => 'nullable|date',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $validated['status']   = (int) $validated['status'];
        $validated['priority'] = (int) $validated['priority'];

        if ($request->hasFile('attachment')) {
            if ($task->attachment) {
                Storage::disk('public')->delete($task->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $task->update($validated);
        $task->tags()->sync($request->input('tags', []));

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        if ($task->attachment) {
            Storage::disk('public')->delete($task->attachment);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function toggleStatus(Task $task)
    {
        $this->authorizeTask($task);

        $task->status = $task->isDone() ? Task::PENDING : Task::DONE;
        $task->save();

        return response()->json([
            'status' => $task->status,
        ]);
    }

    /**
     * Abort with 403 if the task does not belong to the authenticated user.
     */
    private function authorizeTask(Task $task): void
    {
        abort_unless($task->user_id === auth()->id(), 403);
    }
}
