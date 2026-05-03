<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private readonly TaskService $taskService) {}

    public function index(Request $request)
    {
        $stats       = $this->taskService->getStats($request->user());
        $recentTasks = $this->taskService->query($request->user())->take(5)->get();

        return view('dashboard', compact('stats', 'recentTasks'));
    }
}
