@extends('layout-signed')

@section('title', 'Task time tracking')
@section('breadcrumb', 'Task time tracking')

@section('content')
    <div class="pb-4 text-right mb-2">
        <a href="{{ route('tracking.create', $task->id) }}" class="focus:outline-none text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-base px-5 py-2.5 mb-2">Create new item</a>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-slate-500">
            <thead class="text-xs text-white uppercase bg-slate-500">
            <tr>
                <th scope="col" class="px-6 py-3">Date</th>
                <th scope="col" class="px-6 py-3">Time spent</th>
                <th scope="col" class="px-6 py-3">Note</th>
                <th scope="col" class="px-6 py-3">Created</th>
                <th scope="col" class="px-6 py-3"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($trackingItems as $trackingItem)
                <tr class="bg-white border-b">
                    <td class="px-6 py-2">{{ $trackingItem->item_date->format("d.m.Y") }}</td>
                    <td class="px-6 py-2">{{ $trackingItem->item_hours }} hours</td>
                    <td class="px-6 py-2">{{ $trackingItem->item_note }}</td>
                    <td class="px-6 py-2">{{ $trackingItem->created_at->format("d.m.Y H:i:s") }}</td>
                    <td class="px-6 py-2 flex flex-row justify-end">
                        <div>
                            <form action="{{ route('tracking.destroy', $trackingItem->id) }}" method="post" id="tracking-time-{{ $trackingItem->id }}-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        form="tracking-time-{{ $trackingItem->id }}-delete-form"
                                        onclick="return confirm('Are you sure ?');" class="text-white bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Delete
                                </button>
                            </form>
                        </div>
                        <div class="ml-2 pt-2.5">
                            <a href="{{ route('tracking.edit', $trackingItem->id) }}" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-3.5 text-center">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-2">
        {{ $trackingItems->links() }}
    </div>
@endsection
