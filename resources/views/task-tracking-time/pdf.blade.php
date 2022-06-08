<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,400;1,200&display=swap" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <title>PDF export</title>

    <style>
        body {
            font-family: 'Josefin Sans', sans-serif;
        }

        .cursor-default {
            background-color: cornflowerblue !important;
            color: white !important;
        }
    </style>
</head>

<body class="text-base">

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-left text-gray-500">
        <thead class="text-gray-700 uppercase bg-gray-200">
        <tr>
            <th scope="col" class="px-6 py-3">Date</th>
            <th scope="col" class="px-6 py-3">Task</th>
            <th scope="col" class="px-6 py-3">Amount (hours)</th>
            <th scope="col" class="px-6 py-3">Note</th>
        </tr>
        </thead>
        <tbody>
        @php
            $dailySum = 0;
            $monthlySum = 0;
        @endphp
        @foreach($trackingItems as $item)
            @if((!$loop->first && $date->format('d.m.Y') != $item->record_date->format('d.m.Y')))
                {{-- Display daily sum on every day change --}}
                <tr class="text-gray-700 uppercase bg-gray-200">
                    <th scope="col" class="px-6 py-3" colspan="2">{{ $date->format('d.m.Y') }} day in total</th>
                    <th scope="col" class="px-6 py-3" colspan="2">{{ $dailySum }} hours</th>
                </tr>

                @php
                    $dailySum = 0;
                @endphp
            @endif

            <tr class="bg-white border-b">
                <td class="px-6 py-2">{{ $item->record_date->format('d.m.Y') }}</td>
                <td class="px-6 py-2">{{ $item->task->task_name }}</td>
                <td class="px-6 py-2">{{ $item->spent_time }}</td>
                <td class="px-6 py-2">{{ $item->note }}</td>
            </tr>

            @if($loop->last)
                {{-- Display daily sum on every day change --}}
                <tr class="text-gray-700 uppercase bg-gray-200">
                    <th scope="col" class="px-6 py-3" colspan="2">{{ $date->format('d.m.Y') }} day in total</th>
                    <th scope="col" class="px-6 py-3" colspan="2">{{ $dailySum }} hours</th>
                </tr>
            @endif

            @php
                $dailySum += $item->spent_time;
                $monthlySum += $item->spent_time;
                $date = $item->record_date;
                $task = $item->task_id;
            @endphp
        @endforeach
        </tbody>
    </table>

    @if($monthlySum > 0)
        <div class="pt-6 text-center text-5xl uppercase">
            In month: {{ $date->format('m/Y') }} spent <span class="text-green-500">{{ $monthlySum }}</span> hours in total
        </div>
    @else
        <div class="pt-6 text-center text-5xl uppercase">
            NO DATA
        </div>
    @endif
</div>


<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
