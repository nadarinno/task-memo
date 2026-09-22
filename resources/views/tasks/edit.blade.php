@extends('layouts.app')

@section('content')
    <h2>Edit Task</h2>

    @include('tasks.form', [
        'action' => route('tasks.update', $task),
        'method' => 'PUT',
        'task' => $task
    ])
@endsection