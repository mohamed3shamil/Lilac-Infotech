@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">My Tasks</h1>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                Create New Task
            </a>
        </div>

        <div class="mb-4">
            <label for="status-filter" class="mr-2">Filter by Status:</label>
            <select id="status-filter" class="border rounded px-3 py-2">
                <option value="">All</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
        </div>

        @if($tasks->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white text-center">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Title</th>
                            <th class="py-2 px-4 border-b">Description</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Due Date</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr class="task-row" data-status="{{ $task->status }}">
                            <td class="py-2 px-4 border-b">{{ $task->title }}</td>
                            <td class="py-2 px-4 border-b">{{ Str::limit($task->description, 50) }}</td>
                            <td class="py-2 px-4 border-b">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $task->status === 'Completed' ? 'bg-green-200 text-green-800' : 
                                       ($task->status === 'In Progress' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td class="py-2 px-4 border-b">{{ $task->due_date->format('M d, Y') }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" 
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No tasks found. <a href="{{ route('tasks.create') }}" class="text-blue-500 hover:text-blue-700">Create your first task!</a></p>
        @endif
    </div>
</div>

<script>
    document.getElementById('status-filter').addEventListener('change', function() {
        const status = this.value;
        const rows = document.querySelectorAll('.task-row');
        
        rows.forEach(row => {
            if (status === '' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection