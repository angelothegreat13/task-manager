<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Tag;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->string('search')->trim();
        $status   = $request->string('status')->trim();
        $priority = $request->string('priority')->trim();

        $tasks = $request->user()->tasks()
            ->with('tags')
            ->when($search,   fn ($q) => $q->where(fn ($q) => $q
                ->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")))
            ->when($status->isNotEmpty(),   fn ($q) => $q->where('status', $status))
            ->when($priority->isNotEmpty(), fn ($q) => $q->where('priority', $priority))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks', 'search', 'status', 'priority'));
    }

    public function create()
    {
        $tags = Tag::latest()->get();

        return view('tasks.create', compact('tags'));
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $request->user()->tasks()->create($request->safe()->except('tags'));

        if ($request->filled('tags')) {
            $task->tags()->attach($request->validated('tags'));
        }

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
        $task->update($request->safe()->except('tags'));

        $task->tags()->sync($request->validated('tags', []));

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
