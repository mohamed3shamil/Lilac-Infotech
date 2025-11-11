@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">

        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6">
            <p>Welcome back, {{ auth()->user()->name }}!</p>
            <p>Total Tasks: {{ auth()->user()->tasks()->count() }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Total Tasks</h3>
                <p class="text-3xl font-bold text-blue-600">{{ auth()->user()->tasks()->count() }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Completed</h3>
                <p class="text-3xl font-bold text-green-600">{{ auth()->user()->tasks()->where('status', 'Completed')->count() }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">In Progress</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ auth()->user()->tasks()->where('status', 'In Progress')->count() }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="flex space-x-4">
                <a href="{{ route('tasks.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    View All Tasks
                </a>
                <a href="{{ route('tasks.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                    Create New Task
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Tasks</h3>
            
            @php
                $tasks = auth()->user()->tasks()->latest()->take(5)->get();
            @endphp

            @if($tasks->count() > 0)
                <div class="space-y-3">
                    @foreach($tasks as $task)
                    <div class="flex justify-between items-center p-3 border rounded">
                        <div>
                            <span class="font-medium">{{ $task->title }}</span>
                            <span class="ml-2 px-2 py-1 text-xs rounded 
                                @if($task->status === 'Completed') bg-green-200 text-green-800
                                @elseif($task->status === 'In Progress') bg-yellow-200 text-yellow-800
                                @else bg-red-200 text-red-800 @endif">
                                {{ $task->status }}
                            </span>
                        </div>
                        <span class="text-sm text-gray-500">{{ $task->due_date->format('M d, Y') }}</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No tasks found. <a href="{{ route('tasks.create') }}" class="text-blue-500 hover:text-blue-700">Create your first task!</a></p>
            @endif
        </div>
    </div>
</div>
@endsection