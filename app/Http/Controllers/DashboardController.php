<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::first();

        // dd($user);

        $stats = [
            'total' => 10,
            'pending' => 9,
            'in_progress' => 8,
            'completed' => 7
        ];

        $recentTasks = Task::all();

        return view('dashboard', compact('stats', 'recentTasks'));
    }

}