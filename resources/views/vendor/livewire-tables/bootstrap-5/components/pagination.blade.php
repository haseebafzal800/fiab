@aware(['component'])
@props(['rows'])

@php
    $theme = $component->getTheme();
@endphp

@if ($component->hasConfigurableAreaFor('before-pagination'))
    @include($component->getConfigurableAreaFor('before-pagination'), $component->getParametersForConfigurableArea('before-pagination'))
@endif

@if ($theme === 'tailwind')
    <div>
        @if ($component->paginationVisibilityIsEnabled())
            <div class="mt-4 px-4 md:p-0 sm:flex justify-between items-center space-y-4 sm:space-y-0">
                <div>
                    @if ($component->paginationIsEnabled() && $rows->lastPage() > 1)
                        <p class="paged-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                            <span>@lang('Showing')</span>
                            <span class="font-medium">{{ $rows->firstItem() }}</span>
                            <span>@lang('to')</span>
                            <span class="font-medium">{{ $rows->lastItem() }}</span>
                            <span>@lang('of')</span>
                            <span class="font-medium">{{ $rows->total() }}</span>
                            <span>@lang('results')</span>
                        </p>
                    @else
                        <p class="total-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                            @lang('Showing')
                            <span class="font-medium">{{ $rows->count() }}</span>
                            @lang('results')
                        </p>
                    @endif
                </div>

                @if ($component->paginationIsEnabled())
                    {{ $rows->links('livewire-tables::specific.tailwind.pagination') }}
                @endif
            </div>
        @endif
    </div>
@elseif ($theme === 'bootstrap-4')
    <div>
        @if ($component->paginationVisibilityIsEnabled())
            @if ($component->paginationIsEnabled() && $rows->lastPage() > 1)
                <div class="row mt-3">
                    <div class="col-12 col-md-6 overflow-auto">
                        {{ $rows->links('livewire-tables::specific.bootstrap-4.pagination') }}
                    </div>

                    <div class="col-12 col-md-6 text-center text-md-right text-muted">
                        <span>@lang('Showing')</span>
                        <strong>{{ $rows->count() ? $rows->firstItem() : 0 }}</strong>
                        <span>@lang('to')</span>
                        <strong>{{ $rows->count() ? $rows->lastItem() : 0 }}</strong>
                        <span>@lang('of')</span>
                        <strong>{{ $rows->total() }}</strong>
                        <span>@lang('results')</span>
                    </div>
                </div>
            @else
                <div class="row mt-3">
                    <div class="col-12 text-muted">
                        @lang('Showing')
                        <strong>{{ $rows->count() }}</strong>
                        @lang('results')
                    </div>
                </div>
            @endif
        @endif
    </div>
@elseif ($theme === 'bootstrap-5')
    <div class="d-flex align-items-center flex-md-row flex-column">
        @if ($component->paginationVisibilityIsEnabled())
            @if ($component->paginationIsEnabled() && $component->perPageVisibilityIsEnabled())
                <div
                    class="ms-0 ms-md-2 mb-sm-0 mb-3 d-flex align-items-center justify-content-sm-start justify-content-center">
                    <span class="me-2 text-show">@lang('Show')</span>
                    <select
                        wire:model="perPage"
                        id="perPage"
                        class="form-select w-auto data-sorting pl-1 pr-5 py-2"
                    >
                        @foreach ($component->getPerPageAccepted() as $item)
                            <option value="{{ $item }}"
                                    wire:key="per-page-{{ $item }}-{{ $component->getTableName() }}">{{ $item === -1 ? __('All') : $item }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($component->paginationIsEnabled() && $rows->lastPage() > 1)
                    <div class="row flex-md-row-reverse flex-column-reverse mx-0 w-100">
                        <div class="col-12 col-md-6 overflow-auto pagination-center ms-auto">
                            {{ $rows->links('livewire-tables::specific.bootstrap-4.pagination') }}
                        </div>
                        <div
                            class="col-12 col-md-6 text-center text-md-end text-muted d-flex align-items-center justify-content-md-start justify-content-center mb-md-0 mb-4 flex-wrap">
                            <div class="ms-3 text-md-dark">
                                <span>@lang('Showing')</span>
                                <strong>{{ $rows->count() ? $rows->firstItem() : 0 }}</strong>
                                <span>@lang('to')</span>
                                <strong>{{ $rows->count() ? $rows->lastItem() : 0 }}</strong>
                                <span>@lang('of')</span>
                                <strong>{{ $rows->total() }}</strong>
                                <span>@lang('results')</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12 ms-3 text-md-dark">
                            @lang('Showing')
                            <strong>{{ $rows->count() }}</strong>
                            @lang('results')
                        </div>
                    </div>
                @endif
            @endif
        @endif
    </div>
@endif

@if ($component->hasConfigurableAreaFor('after-pagination'))
    @include($component->getConfigurableAreaFor('after-pagination'), $component->getParametersForConfigurableArea('after-pagination'))
@endif
