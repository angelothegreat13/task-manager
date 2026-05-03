<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskApiController extends Controller
{
    public function __construct(private readonly TaskService $taskService) {}

    public function index()
    {
        // $tasks = Task::with('tags')->paginate(10);
        $tasks = Task::with('tags')->paginate(10);

        return TaskResource::collection($tasks)->response()->setStatusCode(202);
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        // $task = $request->user()->tasks()->create($request->safe()->except('tags'));
        // $task->tags()->sync($request->validated('tags', []));

        // return new TaskResource($task->load('tags'));
    }

    public function show(Task $task): TaskResource
    {
        // $this->authorize('view', $task);

        // return new TaskResource($task->load('tags'));
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        // $task->update($request->safe()->except('tags'));
        // $task->tags()->sync($request->validated('tags', []));

        // return new TaskResource($task->load('tags'));
    }

    public function destroy(Task $task): Response
    {
        // $this->authorize('delete', $task);
        // $task->delete();

        // return response()->noContent();
    }
}
