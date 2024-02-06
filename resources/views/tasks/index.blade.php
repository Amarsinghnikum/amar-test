@extends('layouts.app')

@section('content')
    <h2>All Tasks</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <ul>
        @foreach($tasks as $task)
            <li>
                <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                (Status: {{ $task->status }}, Due Date: {{ $task->due_date->format('M d, Y') }})
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Edit</a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('tasks.create') }}" class="btn btn-success">Create New Task</a>
@endsection
