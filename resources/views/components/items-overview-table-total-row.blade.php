@props(['date', 'dailySum'])

<tr class="text-gray-700 uppercase bg-gray-200 text-xl">
    <th scope="col" class="px-6 py-3" colspan="4">
        <span class="flex">
            <span class="grow">Total in: {{ $date->format('d.m.Y') }}</span>
            <span>{{ $dailySum }} hours</span>
        </span>
    </th>
</tr>
