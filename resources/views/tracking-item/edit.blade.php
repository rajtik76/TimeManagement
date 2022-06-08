@extends('layout-signed')

@section('title', 'Edit tracking time')
@section('breadcrumb', 'Edit tracking time')

@section('content')
    <form method="post" action="{{ route(isset($flagNewItem) ? 'tracking.store' : 'tracking.update', $item->id) }}" id="tracking-edit-form">
        @csrf
        @if(!isset($flagNewItem))
            {{-- display tracking item id only in edit + set PUT method --}}
            @method('PUT')
            <div class="mb-6">
                <label for="tracking_item_id" class="block mb-2 text-sm font-medium text-slate-500">Tracking item ID</label>
                <span id="tracking_item_id" class="border border-slate-300 text-slate-500 text-sm rounded-lg block w-24 p-2.5">{{ $item->id }}</span>
            </div>
        @endif

        <div class="mb-6">
            <label for="item_date" class="block mb-2 text-sm font-medium text-slate-500">Date</label>
            <input type="date"
                   name="item_date"
                   id="item_date"
                   value="{{ old('item_date', $item->item_date?->format('Y-m-d')) }}"
                   class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-30 p-2.5" required>
            @error('item_date')
            <div class="text-sm text-red-600">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="item_hours" class="block mb-2 text-sm font-medium text-slate-500">Time spent</label>
            <input type="text"
                   name="item_hours"
                   id="item_hours"
                   value="{{ old('item_hours', $item->item_hours) }}"
                   class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 p-2.5" required>
            @error('item_hours')
            <div class="text-sm text-red-600">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="item_note" class="block mb-2 text-sm font-medium text-slate-500">Note</label>
            <input type="text"
                   name="item_note"
                   id="item_note"
                   value="{{ old('note', $item->item_note) }}"
                   class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @error('item_note')
            <div class="text-sm text-red-600">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="flex flex-row">
            <div class="grow">
                <button type="submit" form="tracking-edit-form"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center grow">
                    Submit
                </button>
            </div>
        </div>

        @if(isset($task))
            <input type="hidden" name="task_id" value="{{ $task->id }}">
        @endif
    </form>
@endsection
