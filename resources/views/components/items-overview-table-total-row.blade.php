@props(['date', 'dailySum'])

<tr class="text-black uppercase bg-gray-200 text-lg">
    <th scope="col" class="px-6 py-3">
        {{ $date->format('d.m.Y') }}
    </th>
    <th scope="col" class="px-6 py-3">
        total
    </th>
    <th scope="col" class="px-6 py-3" colspan="2">
        <span>{{ $dailySum }} hours</span>
    </th>
</tr>
