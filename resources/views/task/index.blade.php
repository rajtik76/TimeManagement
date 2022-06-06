@extends('layout_signed')

@section('title', 'Task index')

@section('root-style')
    <style>
        .cursor-default {
            background-color: dodgerblue !important;
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <table class="table-auto w-full text-sm">
        <thead>
        <tr class="text-left bg-blue-50 text-lg">
            <th class="py-4">Task name</th>
            <th>Time spent</th>
            <th>Notes</th>
            <th>URL</th>
            <th class="text-center">Detail</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr class="hover:bg-violet-100">
                <td>{{ $task->task_name }}</td>
                <td>{{ $task->tracking_times_sum_spent_time }}</td>
                <td>{{ $task->task_notes }}</td>
                <td>{{ $task->task_url }}</td>
                <td class="p-2">
                    <a class="bg-blue-400 p-2 rounded-md text-sm" href="{{ route('task.edit', $task->id) }}">Detail</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pt-8">
        {{ $tasks->links() }}
    </div>
@endsection
