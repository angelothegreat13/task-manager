@extends('layouts.master')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-1 text-sm text-gray-500">Welcome back, {{ auth()->user()->name }}</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Total Tasks</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Pending</p>
            <p class="mt-2 text-3xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">In Progress</p>
            <p class="mt-2 text-3xl font-bold text-blue-500">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Completed</p>
            <p class="mt-2 text-3xl font-bold text-teal-600">{{ $stats['completed'] }}</p>
        </div>
    </div>

    {{-- Recent Tasks --}}
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Recent Tasks</h2>
            <a href="{{ route('tasks.index') }}" class="text-sm font-medium text-teal-600 hover:underline">View all</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentTasks as $task)
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $task->title }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Due: {{ $task->due_date?->format('M d, Y') ?? 'No due date' }}</p>
                    </div>
                    <span @class([
                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                        'bg-yellow-100 text-yellow-700' => $task->status === 'pending',
                        'bg-blue-100 text-blue-700'   => $task->status === 'in progress',
                        'bg-teal-100 text-teal-700'   => $task->status === 'completed',
                    ])>{{ Str::headline($task->status) }}</span>
                </div>
            @empty
                <p class="px-6 py-8 text-center text-sm text-gray-400">No tasks yet. <a href="{{ route('tasks.create') }}" class="text-teal-600 hover:underline">Create one</a>.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
