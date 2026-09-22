@extends('layouts.app')

@section('content')
    <h2>Add New Task</h2>

    @include('tasks.form', [
        'action' => route('tasks.store'),
        'method' => 'POST',
        'task' => null
    ])
@endsection