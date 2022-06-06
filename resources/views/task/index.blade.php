@extends('layout_signed')

@section('title', 'task index')

@section('root-style')
    <style>
        .cursor-default {
            background-color: lightblue !important;
        }
    </style>
@endsection

@section('content')
    <table class="table-auto w-full text-sm">
        <thead>
        <tr class="text-left bg-pink-50 text-lg">
            <th class="py-4"><I></I>D</th>
            <th>Task name</th>
            <th>Notes</th>
            <th>URL</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr class="hover:bg-slate-100">
                <td>{{ $task->id }}</td>
                <td>{{ $task->task_name }}</td>
                <td>{{ $task->task_notes }}</td>
                <td>{{ $task->task_url }}</td>
                <td>
                    <div class="flex flex-row text-white">
                        <a class="bg-blue-400 px-2 py-1 m-1 rounded-md" href="#">Edit</a>
                        <a class="bg-red-400 px-2 py-1 m-1 rounded-md" href="#">Delete</a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pt-8">
        {{ $tasks->links() }}
    </div>
@endsection
