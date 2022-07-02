@props(['grid'])

@php
    /** @var \App\Services\Grid\Grid $grid */
@endphp

<div class="relative overflow-x-auto shadow-md rounded-lg">
    <table class="w-full table-auto text-sm text-left text-gray-500">
        {{--  header --}}
        <thead class="text-xs text-white uppercase bg-slate-500">
        <tr>
            @php($haveFilteredColumns = false)
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
                    @if($column->isFilterable())
                        @php($haveFilteredColumns = true)
                    @endif
                </th>
            @endforeach

            @if($grid->getActions())
                <th scope="col" class="px-6 py-3 border">Actions</th>
            @endif
        </tr>

        {{-- filters --}}
        @if($haveFilteredColumns)
            <tr>
                @foreach($grid->getColumns() as $column)
                    <th scope="col" class="bg-slate-50 border px-1 pb-2">
                        @if($column->isFilterable())
                            <select id="column-{{ $column->getName() }}-select"
                                    class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full"
                                    onchange="onFilterChange(this)">
                                @foreach($column->getFilterOptions() as $key => $value)
                                    <option value="{{ $key }}" @selected($key == $column->getCurrentFilter()) data-filter-link="{{ $column->getFilterLink($key) }}">{{ $value }}</option>
                                @endforeach
                            </select>

                            <script type="text/javascript">
                                function onFilterChange(el) {
                                    window.location.href = el.options[el.selectedIndex].dataset.filterLink;
                                }
                            </script>
                        @endif
                    </th>
                @endforeach

                @if($grid->getActions())
                    <th scope="col" class="bg-slate-50 border px-1 pb-2"></th>
                @endif
            </tr>
        @endif
        </thead>

        {{-- body --}}
        <tbody>
        @foreach($grid->getData() as $data)
            <tr class="bg-white border-b hover:bg-slate-100 {{ $grid->getConditionalRowClass() ? call_user_func($grid->getConditionalRowClass(), $data) : ''}}">
                @foreach($grid->getColumns() as $column)
                    <td class="px-6 py-2 border">
                        @if($column->getRenderWrapper())
                            {!! $column->render($data) !!}
                        @else
                            {{ $column->render($data) }}
                        @endif
                    </td>
                @endforeach

                {{-- actions --}}
                @if($grid->getActions())
                    <td class="px-6 py-2 border flex flex-row gap-1 items-center">
                        @foreach($grid->getActions() as $action)
                            <span>{!! $action->render($data) !!}</span>
                        @endforeach
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>

    </table>
</div>

<div class="pt-8">
    {{ $grid->getData()->withQueryString()->links() }}
</div>
