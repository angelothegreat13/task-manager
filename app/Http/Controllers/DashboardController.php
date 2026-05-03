<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->latest()->get();

        $stats = [
            'total'       => $tasks->count(),
            'pending'     => $tasks->where('status', 'pending')->count(),
            'in_progress' => $tasks->where('status', 'in progress')->count(),
            'completed'   => $tasks->where('status', 'completed')->count(),
        ];

        $recentTasks = $tasks->take(5);

        return view('dashboard', compact('stats', 'recentTasks'));
    }
}
