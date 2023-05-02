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
                    <component :is="'style'">
                        @if($table->getRightFrozenColsCount() > 0)
                            /* freeze last n columns */
                            #{{ $table->getTableId() }} th:nth-last-child(-n+{{ $table->getRightFrozenColsCount() }}),
                            #{{ $table->getTableId() }} td:nth-last-child(-n+{{ $table->getRightFrozenColsCount() }}) {
                            position: sticky;
                            right: -1px;
                            z-index: 1;
                            background-color: white;
                            }
                            /* header bg and row hover */
                            #{{ $table->getTableId() }} th:nth-last-child(-n+{{ $table->getRightFrozenColsCount() }}),
                            background-color: #F9FAFB;
                            }
                            #{{ $table->getTableId() }} tr:hover th:nth-last-child(-n+{{ $table->getRightFrozenColsCount() }}),
                            #{{ $table->getTableId() }} tr:hover td:nth-last-child(-n+{{ $table->getRightFrozenColsCount() }}) {
                            background-color: #F9FAFB;
                            }
                        @endif

                        @if($table->getLeftFrozenColsCount() > 0)
                            /* freeze first n columns */
                            #{{ $table->getTableId() }} th:nth-child(-n+{{ $table->getLeftFrozenColsCount() }}),
                            #{{ $table->getTableId() }} td:nth-child(-n+{{ $table->getLeftFrozenColsCount() }}) {
                            position: sticky;
                            left: -1px;
                            z-index: 1;
                            background-color: white;
                            }
                            /* header bg and row hover */
                            #{{ $table->getTableId() }} th:nth-child(-n+{{ $table->getLeftFrozenColsCount() }}) {
                            background-color: #F9FAFB;
                            }
                            #{{ $table->getTableId() }} tr:hover th:nth-child(-n+{{ $table->getRightFrozenColsCount() }}),
                            #{{ $table->getTableId() }} tr:hover td:nth-child(-n+{{ $table->getRightFrozenColsCount() }}) {
                            background-color: #F9FAFB;
                            }
                        @endif
                    </component>
                @endif
                <table id="{{ $table->getTableId() }}" class="min-w-full divide-y divide-gray-200 bg-white">
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
