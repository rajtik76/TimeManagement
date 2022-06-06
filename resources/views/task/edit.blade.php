@extends('layout_signed')

@section('title', 'Task detail')

@section('content')
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap justify-center -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 rounded-t-lg border-b-2 text-blue-600 hover:text-blue-600 border-blue-600" id="profile-tab" data-tabs-target="#task" type="button" role="tab" aria-controls="task" aria-selected="true">Task
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 text-grey-500 border-gray-100" id="dashboard-tab" data-tabs-target="#task-tracking-time" type="button"
                        role="tab" aria-controls="task-tracking-time" aria-selected="false">Task tracking time
                </button>
            </li>
        </ul>
    </div>
    <div id="myTabContent">
        <div class="p-4 bg-gray-50 rounded-lg" id="task" role="tabpanel" aria-labelledby="profile-tab">
            <div class="text-2xl text-center p-2 mb-1 bg-blue-50">Task edit</div>
            <form method="post" action="{{ route('task.update', $task->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label for="task_name" class="block mb-2 text-sm font-medium text-black">Task name</label>
                    <input type="text"
                           name="task_name"
                           id="task_name"
                           value="{{ old('task_name', $task->task_name) }}"
                           class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" {{--required--}}>
                    @error('task_name')
                    <div class="text-sm text-red-600">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="task_notes" class="block mb-2 text-sm font-medium text-black">Task Notes</label>
                    <input type="text"
                           name="task_notes"
                           id="task_notes"
                           value="{{ old('task_notes', $task->task_notes) }}"
                           class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                @error('task_notes')
                <div class="text-sm text-red-600">
                    {{ $message }}
                </div>
                @enderror

                <div class="mb-6">
                    <label for="task_url" class="block mb-2 text-sm font-medium text-black">Task URL</label>
                    <input type="text"
                           name="task_url"
                           id="task_url"
                           value="{{ old('task_url', $task->task_url) }}"
                           class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                @error('task_url')
                <div class="text-sm text-red-600">
                    {{ $message }}
                </div>
                @enderror

                <div class="flex items-start mb-6">
                    <label for="is_active" class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox" name="is_active" @checked(old('is_active', $task->is_active)) id="is_active" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-black">Active task</span>
                    </label>
                </div>
                @error('is_active')
                <div class="text-sm text-red-600">
                    {{ $message }}
                </div>
                @enderror

                <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </form>
        </div>
        <div class="hidden p-4 bg-gray-50 rounded-lg" id="task-tracking-time" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="relative overflow-x-auto">
                <table class="w-1/2 text-sm text-left mx-auto">
                    <thead class="text-base uppercase bg-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Time</th>
                        <th scope="col" class="px-6 py-3">Created</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($task->trackingTimes()->orderByRaw('record_date desc, created_at desc')->get() as $trackingTime)
                        <tr class="bg-white border-b bg-slate-50 hover:bg-blue-100">
                            <td class="px-6 py-1 font-medium whitespace-nowrap">
                                {{ $trackingTime->record_date }}
                            </td>
                            <td class="px-6">
                                {{ $trackingTime->spent_time }}
                            </td>
                            <td class="px-6">
                                {{ $trackingTime->created_at }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="text-base uppercase bg-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">SUM</th>
                        <th scope="col" colspan="2" class="px-6 py-3">{{ $sum }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
