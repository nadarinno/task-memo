@extends('layouts.app')

@section('content')
    <h2>My Tasks</h2>

    <a href="{{ route('tasks.create') }}" class="btn">Add New Task</a>

    @if($tasks->count())
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Attachment</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>

                        <td>{{ str_replace('_', ' ', ucfirst($task->status)) }}</td>

                        <td>
                            {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No date' }}
                        </td>

                        <td>
                            @if($task->attachment_path)
                                <a href="{{ asset('storage/' . $task->attachment_path) }}" target="_blank">
                                    {{ $task->attachment_original_name }}
                                </a>
                            @else
                                No attachment
                            @endif
                        </td>

                        <td>{{ $task->created_at->format('Y-m-d H:i') }}</td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">View</a>

                                <a href="{{ route('tasks.edit', $task) }}" class="btn">Edit</a>

                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this task?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $tasks->links() }}
        </div>
    @else
        <p>No tasks found.</p>
    @endif
@endsection