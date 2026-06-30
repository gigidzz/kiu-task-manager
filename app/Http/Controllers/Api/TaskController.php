<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * GET /api/tasks — list the authenticated user's tasks as JSON.
     */
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->with('tags')->latest()->paginate(10);

        return TaskResource::collection($tasks);
    }

    /**
     * POST /api/tasks — create a task and return it as JSON.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject'     => 'required|string|max:255',
            'status'      => 'required|in:0,1',
            'priority'    => 'required|in:0,1,2',
            'deadline'    => 'nullable|date',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $task = $request->user()->tasks()->create($validated);
        $task->tags()->sync($request->input('tags', []));

        return (new TaskResource($task->load('tags')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * GET /api/tasks/{task} — show a single task as JSON.
     */
    public function show(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        return new TaskResource($task->load('tags'));
    }

    /**
     * PUT/PATCH /api/tasks/{task} — update and return the task as JSON.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'subject'     => 'sometimes|required|string|max:255',
            'status'      => 'sometimes|required|in:0,1',
            'priority'    => 'sometimes|required|in:0,1,2',
            'deadline'    => 'nullable|date',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $task->update($validated);

        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags', []));
        }

        return new TaskResource($task->load('tags'));
    }

    /**
     * DELETE /api/tasks/{task} — delete the task, return JSON confirmation.
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully.']);
    }

    /**
     * Abort with 403 if the task does not belong to the requesting user.
     */
    private function authorizeTask(Request $request, Task $task): void
    {
        abort_unless($task->user_id === $request->user()->id, 403, 'This task does not belong to you.');
    }
}
