@extends('layouts.master')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">
            + New Task
        </a>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-6 flex flex-col gap-3 sm:flex-row">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search tasks..."
            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
        >
        <select name="status" class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            <option value="">All Status</option>
            <option value="pending"     {{ request('status') === 'pending'     ? 'selected' : '' }}>Pending</option>
            <option value="in progress" {{ request('status') === 'in progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed"   {{ request('status') === 'completed'   ? 'selected' : '' }}>Completed</option>
        </select>
        <select name="priority" class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            <option value="">All Priority</option>
            <option value="low"    {{ request('priority') === 'low'    ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high"   {{ request('priority') === 'high'   ? 'selected' : '' }}>High</option>
        </select>
        <button type="submit" class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200">
            Filter
        </button>
    </form>

    {{-- Table --}}
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tags</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $task->title }}</td>
                        <td class="px-6 py-4">
                            <span @class([
                                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                'bg-yellow-100 text-yellow-700' => $task->status === 'pending',
                                'bg-blue-100 text-blue-700'     => $task->status === 'in progress',
                                'bg-teal-100 text-teal-700'     => $task->status === 'completed',
                            ])>{{ Str::headline($task->status) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span @class([
                                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                'bg-gray-100 text-gray-600'     => $task->priority === 'low',
                                'bg-orange-100 text-orange-600' => $task->priority === 'medium',
                                'bg-red-100 text-red-600'       => $task->priority === 'high',
                            ])>{{ Str::headline($task->priority) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $task->due_date?->format('M d, Y') ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($task->tags as $tag)
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-600">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('tasks.edit', $task) }}" class="text-sm font-medium text-teal-600 hover:underline">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                            No tasks found. <a href="{{ route('tasks.create') }}" class="text-teal-600 hover:underline">Create one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($tasks->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $tasks->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
