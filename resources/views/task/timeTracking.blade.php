@extends('layoutSigned')

@section('title', 'Task time tracking')
@section('breadcrumb', 'Task time tracking')

@section('content')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-slate-500">
            <thead class="text-xs text-white uppercase bg-slate-500">
            <tr>
                <th scope="col" class="px-6 py-3">Date</th>
                <th scope="col" class="px-6 py-3">Time spent</th>
                <th scope="col" class="px-6 py-3">Created</th>
            </tr>
            </thead>
            <tbody>
            @foreach($trackingTimes as $trackingTime)
                <tr class="bg-white border-b">
                    <td class="px-6 py-2">{{ $trackingTime->record_date->format("d.m.Y") }}</td>
                    <td class="px-6 py-2">{{ $trackingTime->spent_time }} hours</td>
                    <td class="px-6 py-2">{{ $trackingTime->created_at->format("d.m.Y H:i:s") }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-2">
        {{ $trackingTimes->links() }}
    </div>
@endsection
