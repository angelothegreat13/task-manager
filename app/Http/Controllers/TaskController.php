<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Tag;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService) {}

    public function index(Request $request)
    {
        $tasks = $this->taskService->filteredQuery(
            $request->user(),
            (string) $request->string('search')->trim(),
            (string) $request->string('status')->trim(),
            (string) $request->string('priority')->trim(),
        )->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $tags = Tag::latest()->get();

        return view('tasks.create', compact('tags'));
    }

    public function store(StoreTaskRequest $request)
    {
        $this->taskService->createTask($request->user(), $request->validated());

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $tags = Tag::latest()->get();

        return view('tasks.edit', compact('task', 'tags'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->taskService->updateTask($task, $request->validated());

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $this->taskService->deleteTask($task);

        return redirect()->route('tasks.index');
    }
}
