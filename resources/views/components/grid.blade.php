@props(['grid'])

@php
    /** @var \App\Services\Grid\Grid $grid */
@endphp

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-white uppercase bg-slate-500">
        <tr>
            @foreach($grid->getColumns() as $column)
                <th scope="col" class="px-6 py-3">
                    <span class="flex items-stretch">
                        @if($column->isSortable())
                            <a class="underline pr-2" href="{!! $column->getSortLink() !!}">{{ $column->getLabel() }}</a>
                        @else
                            {{ $column->getLabel() }}
                        @endif

                        @if($column->isSortable() && $column->getCurrentSortOrder() !== \App\Services\Grid\ColumnSortOrder::NONE)
                            @if($column->getCurrentSortOrder() === \App\Services\Grid\ColumnSortOrder::ASC)
                                <svg class="w-3.5 h-3.5 self-end" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                </svg>
                            @else
                                <svg class="w-3.5 h-3.5 self-end" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                                </svg>
                            @endif
                        @endif
                    </span>
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($grid->getData() as $row)
            <tr class="bg-white border-b hover:bg-slate-50">
                @foreach($grid->getColumns() as $column)
                    <td class="px-6 py-2">
                        @if($column->getRenderWrapper())
                            {!! $column->render($row) !!}
                        @else
                            {{ $column->render($row) }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="pt-8">
    {{ $grid->getData()->withQueryString()->links() }}
</div>
