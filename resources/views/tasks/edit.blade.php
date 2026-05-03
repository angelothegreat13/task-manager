@extends('layouts.master')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">

    <div class="mb-6">
        <a href="{{ route('tasks.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to tasks</a>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Edit Task</h1>
    </div>

    <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700" for="title">Title</label>
            <input
                id="title"
                name="title"
                type="text"
                value="{{ old('title', $task->title) }}"
                placeholder="Task title"
                class="mt-1 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 {{ $errors->has('title') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-teal-500 focus:ring-teal-500' }}"
            >
            @error('title')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
            <textarea
                id="description"
                name="description"
                rows="3"
                placeholder="Optional description..."
                class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            >{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                <select id="status" name="status" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                    <option value="pending"     {{ old('status', $task->status) === 'pending'     ? 'selected' : '' }}>Pending</option>
                    <option value="in progress" {{ old('status', $task->status) === 'in progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed"   {{ old('status', $task->status) === 'completed'   ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="priority">Priority</label>
                <select id="priority" name="priority" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                    <option value="low"    {{ old('priority', $task->priority) === 'low'    ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high"   {{ old('priority', $task->priority) === 'high'   ? 'selected' : '' }}>High</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700" for="due_date">Due Date</label>
            <input
                id="due_date"
                name="due_date"
                type="date"
                value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            >
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Tags</label>
            <div class="mt-2 flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <label class="flex cursor-pointer items-center gap-1.5">
                        <input
                            type="checkbox"
                            name="tags[]"
                            value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', $task->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                        >
                        <span class="text-sm text-gray-600">{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('tasks.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="rounded-lg bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-700">
                Update Task
            </button>
        </div>
    </form>

</div>
@endsection
