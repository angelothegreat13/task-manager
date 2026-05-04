<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Events\TaskCreated;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class TaskService
{
    public function query(User $user): Builder
    {
        return Task::where('user_id', $user->id)->latest();
    }

    public function filteredQuery(User $user, string $search = '', string $status = '', string $priority = ''): Builder
    {
        return $this->query($user)
            ->with('tags')
            ->when($search,   fn ($q) => $q->where(fn ($q) => $q
                ->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")))
            ->when($status,   fn ($q) => $q->where('status', $status))
            ->when($priority, fn ($q) => $q->where('priority', $priority));
    }

    public function createTask(User $user, array $data): Task
    {
        $task = $user->tasks()->create(Arr::except($data, 'tags'));

        if (!empty($data['tags'])) {
            $task->tags()->attach($data['tags']);
        }

        event(new TaskCreated($task));

        return $task;
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update(Arr::except($data, 'tags'));
        $task->tags()->sync($data['tags'] ?? []);

        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }

    public function getStats(User $user): array
    {
        $tasks = $this->query($user)->get();

        return [
            'total'       => $tasks->count(),
            'pending'     => $tasks->where('status', TaskStatus::Pending)->count(),
            'in_progress' => $tasks->where('status', TaskStatus::InProgress)->count(),
            'completed'   => $tasks->where('status', TaskStatus::Completed)->count(),
        ];
    }
}
