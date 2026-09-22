@extends('layouts.app')

@section('content')
    <h2>Task Details</h2>

    <p><strong>Title:</strong> {{ $task->title }}</p>

    <p>
        <strong>Description:</strong>
        {{ $task->description ?? 'No description' }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ str_replace('_', ' ', ucfirst($task->status)) }}
    </p>

    <p>
        <strong>Due Date:</strong>
        {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No date' }}
    </p>

    <p>
        <strong>Created At:</strong>
        {{ $task->created_at->format('Y-m-d H:i') }}
    </p>

    <p>
        <strong>Last Updated:</strong>
        {{ $task->updated_at->format('Y-m-d H:i') }}
    </p>

    <p>
        <strong>Attachment:</strong>

        @if($task->attachment_path)
            <a href="{{ asset('storage/' . $task->attachment_path) }}" target="_blank">
                {{ $task->attachment_original_name }}
            </a>
        @else
            No attachment
        @endif
    </p>

    <a href="{{ route('tasks.edit', $task) }}" class="btn">Edit</a>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
@endsection