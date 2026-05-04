<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use Illuminate\Support\Facades\Log;

class SendTaskCreatedNotification
{
    public function handle(TaskCreated $event): void
    {
        Log::info('Task created', ['task' => $event->task->toArray()]);
    }
}
