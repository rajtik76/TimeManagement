@extends('layout-signed')

@section('title', 'Task edit')

@section('breadcrumb', 'Task edit')

@section('content')
    @if(!isset($newTaskFlag))
        <form method="post" action="{{ route('task.destroy', $task->id) }}" id="task-delete-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
    <form method="post" action="{{ route(isset($newTaskFlag) ? 'task.store' : 'task.update', $task->id) }}" id="task-edit-form">
        @csrf
        @if(!isset($newTaskFlag))
            {{-- display task id only in edit + set PUT method --}}
            @method('PUT')
            <div class="mb-6">
                <label for="task_id" class="block mb-2 text-sm font-medium text-slate-500">Task ID</label>
                <span id="task_id"
                      value=""
                      class="border border-slate-300 text-slate-500 text-sm rounded-lg block w-24 p-2.5">
                {{ $task->id }}
            </span>
            </div>
        @endif

        <div class="mb-6">
            <label for="task_name" class="block mb-2 text-sm font-medium text-slate-500">Task name</label>
            <input type="text"
                   name="task_name"
                   id="task_name"
                   value="{{ old('task_name', $task->task_name) }}"
                   class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            @error('task_name')
            <div class="text-sm text-red-600">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="task_notes" class="block mb-2 text-sm font-medium text-slate-500">Task Notes</label>
            <input type="text"
                   name="task_notes"
                   id="task_notes"
                   value="{{ old('task_notes', $task->task_notes) }}"
                   class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @error('task_notes')
            <div class="text-sm text-red-600">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="task_url" class="block mb-2 text-sm font-medium text-slate-500">Task URL</label>
            <input type="text"
                   name="task_url"
                   id="task_url"
                   value="{{ old('task_url', $task->task_url) }}"
                   class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @error('task_url')
            <div class="text-sm text-red-600">
                {{ $message }}
            </div>
            @enderror
        </div>

        @if(isset($newTaskFlag))
            <input type="checkbox" name="is_active" checked class="hidden">
        @else
            <div class="flex items-start mb-6 mt-2">
                <label for="is_active" class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" name="is_active" @checked(old('is_active', $task->is_active)) id="is_active" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-slate-500">Active task</span>
                </label>
                @error('is_active')
                <div class="text-sm text-red-600">
                    {{ $message }}
                </div>
                @enderror
            </div>
        @endif

        <div class="flex flex-row">
            <div class="grow">
                <button type="submit" form="task-edit-form" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center grow">
                    Submit
                </button>
            </div>
            @if(!isset($newTaskFlag))
                <div>
                    <button type="submit" form="task-delete-form" onclick="return confirm('Are you sure ?');" class="text-white bg-red-600 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Delete task</button>
                </div>
            @endif
        </div>
    </form>
@endsection
