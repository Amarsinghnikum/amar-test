@extends('layouts.app')

@section('content')
    <h2>Task Details</h2>

    <p><strong>Title:</strong> {{ $task->title }}</p>
    <p><strong>Description:</strong> {{ $task->description ?: 'N/A' }}</p>
    <p><strong>Status:</strong> {{ $task->status }}</p>
    <p><strong>Due Date:</strong> {{ $task->due_date->format('M d, Y') }}</p>

    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Edit Task</a>
    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Task</button>
    </form>

    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Tasks</a>
@endsection
