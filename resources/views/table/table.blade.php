<SpladeTable {{ $attributes->except('class') }}
    :striped="@js($striped)"
    :columns="@js($table->columns())"
    :search-debounce="@js($searchDebounce)"
    :default-visible-toggleable-columns="@js($table->defaultVisibleToggleableColumns())"
    :items-on-this-page="@js($table->totalOnThisPage())"
    :items-on-all-pages="@js($table->totalOnAllPages())"
    :base-url="@js(request()->url())"
>
    <template #default="{!! $scope !!}">
        <div {{ $attributes->only('class') }} :class="{ 'opacity-50': table.isLoading }">
            @if($hasControls())
                @include('splade::table.controls')
            @endif

            @foreach($table->searchInputs() as $searchInput)
                @includeUnless($searchInput->key === 'global', 'splade::table.search-row')
            @endforeach

            <x-splade-component is="table-wrapper">
                @if($table->hasFrozenColumns())
                    <style>
                        @if($table->getRightFrozenColsCount() > 0)
                            /* congela le ultime n colonne */
                            {{ $table->tableId }} th:nth-last-child(-n+{{ $table->getRightFrozenColsCount() }}),
                            {{ $table->tableId }} td:nth-last-child(-n+{{ $table->getRightFrozenColsCount() }}) {
                                position: sticky;
                                right: -1px;
                                z-index: 1;
                                background-color: white;
                            }
                        @endif

                        @if($table->getRightFrozenColsCount() > 0)
                            /* congela le prime n colonne */
                            {{ $table->tableId }} th:nth-child(-n+{{ $table->getLeftFrozenColsCount() }}),
                            {{ $table->tableId }} td:nth-child(-n+{{ $table->getLeftFrozenColsCount() }}) {
                                position: sticky;
                                right: -1px;
                                z-index: 1;
                                background-color: white;
                            }
                        @endif
                    </style>
                @endif
                <table id="{{ $table->tableId }}" class="min-w-full divide-y divide-gray-200 bg-white">
                    @unless($headless)
                        @isset($head)
                            {{ $head }}
                        @elseif(count($table->resource))
                            @include('splade::table.head')
                        @endisset
                    @endunless

                    @isset($body)
                        {{ $body }}
                    @else
                        @include('splade::table.body')
                    @endisset
                </table>
            </x-splade-component>

            @if($showPaginator())
                {{ $table->resource->links($paginationView, ['table' => $table, 'hasPerPageOptions' => $hasPerPageOptions()]) }}
            @endif
        </div>
    </template>
</SpladeTable>
