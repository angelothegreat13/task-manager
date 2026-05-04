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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Jobs\TaskJob;

class TaskApiController extends Controller
{
    public function __construct(private readonly TaskService $taskService) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $tasks = $this->taskService->filteredQuery(
            $request->user(),
            (string) $request->string('search')->trim(),
            (string) $request->string('status')->trim(),
            (string) $request->string('priority')->trim(),
        )->paginate(10);

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->user(), $request->validated());

        return (new TaskResource($task->load('tags')))->response()->setStatusCode(201);
    }

    public function show(Task $task): TaskResource
    {
        $this->authorize('view', $task);

        TaskJob::dispatch($task);

        return new TaskResource($task->load('tags'));
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $task = $this->taskService->updateTask($task, $request->validated());

        return new TaskResource($task->load('tags'));
    }

    public function destroy(Task $task): Response
    {
        $this->authorize('delete', $task);
        $this->taskService->deleteTask($task);

        return response()->noContent();
    }
}
