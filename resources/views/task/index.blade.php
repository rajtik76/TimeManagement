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

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-white uppercase bg-slate-500">
            <tr>
                <th scope="col" class="px-6 py-3">Task name</th>
                <th scope="col" class="px-6 py-3">Time spent</th>
                <th scope="col" class="px-6 py-3">Notes</th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr class="bg-white border-b hover:bg-slate-50">
                    <td class="px-6 py-2">
                        @if($task->task_url)
                            <a class="font-medium text-blue-400 hover:underline" href="{{ $task->task_url }}" target="_blank">{{ $task->task_name }}</a>
                        @else
                            {{ $task->task_name }}
                        @endif
                    </td>
                    <td class="px-6 py-2">{{ $task->tracking_times_sum_spent_time }}</td>
                    <td class="px-6 py-2">{{ $task->task_notes }}</td>
                    <td class="px-6 py-2 text-right">
                        <a href="{{ route('task.edit', $task->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-8">
        {{ $tasks->links() }}
    </div>
@endsection
