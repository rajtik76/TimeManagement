@extends('layoutSigned')

@section('title', 'Task index')

@section('content')
    <div class="flex flex-row">
        <div class="grow">
            <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
                <input type="checkbox" value="" id="default-toggle" class="sr-only peer" @if($inactive) checked @endif onclick="window.location.href = '{{ route('task.index', ['inactive' => !$inactive]) }}';">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900">Display inactive tasks</span>

            </label>
        </div>
        <div class="pb-4">
            <a href="{{ route('task.create') }}" class="focus:outline-none text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-base px-5 py-2.5 mb-2">Create new task</a>
        </div>
    </div>
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
                <tr @class(['bg-white border-b hover:bg-slate-50', 'text-red-400' => !$task->is_active])>
                    <td class="px-6 py-2">
                        @if($task->task_url)
                            <a href="{{ $task->task_url }}" @class(['font-medium hover:underline', 'text-red-400' => !$task->is_active, 'text-blue-400' => $task->is_active]) target="_blank">{{ $task->task_name }}</a>
                        @else
                            {{ $task->task_name }}
                        @endif
                    </td>
                    <td class="px-6 py-2">
                        <a href="{{ route('task.tracking', $task->id) }}" @class(['font-medium hover:underline', 'text-blue-400' => $task->is_active, 'text-red-400' => !$task->is_active])>{{ $task->tracking_times_sum_spent_time ?? '0.0'}}</a>
                    </td>
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
