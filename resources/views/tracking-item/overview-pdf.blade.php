@extends('layout')

@section('title', 'Items overview')

@section('root-content')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        {{-- header --}}
        <div class="py-6 text-5xl uppercase flex flex-row justify-between px-4">
            <span>{{ $customer->name }}</span>
            <span>{{ $date->format('m/Y') }}</span>
        </div>

        {{-- timesheet overview --}}
        <table class="w-full text-left text-gray-500">
            <thead class="text-white uppercase bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Task Name</th>
                    <th scope="col" class="px-6 py-3">Spent time</th>
                    <th scope="col" class="px-6 py-3">Note</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dailySum = 0;
                    $monthlySum = 0;
                @endphp
                @foreach ($items as $item)
                    @if (!$loop->first && $date->format('d.m.Y') != $item->item_date->format('d.m.Y'))
                        {{-- daily total --}}
                        <x-items-overview-table-total-row :date="$date" :daily-sum="$dailySum" />
                        @php
                            $dailySum = 0;
                        @endphp
                    @endif

                    <tr class="bg-white border-b">
                        <td class="px-6 py-2">{{ $item->item_date->format('d.m.Y') }}</td>
                        <td class="px-6 py-2">
                            @if ($item->task->task_url)
                                <a href="{{ $item->task->task_url }}"
                                    class="underline text-blue-500 hover:text-blue-700">{{ $item->task->task_name }}</a>
                            @else
                                {{ $item->task->task_name }}
                            @endif
                        </td>
                        <td class="px-6 py-2">{{ $item->item_hours }}</td>
                        <td class="px-6 py-2">{{ $item->item_note }}</td>
                    </tr>

                    @php
                        $dailySum += $item->item_hours;
                        $monthlySum += $item->item_hours;
                        $date = $item->item_date;
                        $task = $item->task_id;
                    @endphp

                    @if ($loop->last)
                        {{-- monthly total --}}
                        <x-items-overview-table-total-row :date="$date" :daily-sum="$dailySum" />
                    @endif
                @endforeach
            </tbody>
        </table>

        @if ($monthlySum > 0)
            <div class="py-6 text-center text-5xl uppercase">
                Spent <span class="text-green-500">{{ $monthlySum }}</span> hours in total
            </div>
        @else
            <div class="pt-6 text-center text-5xl uppercase">
                NO DATA
            </div>
        @endif
    </div>
@endsection
