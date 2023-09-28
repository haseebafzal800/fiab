<?php

namespace App\Http\Livewire;

use App\Models\Country;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CountriesTable extends LivewireTableComponent
{
    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh', 'resetPage',
    ];

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), 'name')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.country.short_code'), 'short_code')
                    ->sortable()
                    ->searchable(),
            Column::make(__('messages.common.action'))
                    ->addClass('w-100px text-center'),
        ];
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire-tables::'.config('livewire-tables.theme').'.datatable')
            ->with([
                'columns' => $this->columns(),
                'rowView' => $this->rowView(),
                'filtersView' => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows' => $this->rows,
                'modalsView' => $this->modalsView(),
                'bulkActions' => $this->bulkActions,
                'componentName' => 'countries.add_button',
            ]);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Country::query();
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.country_table';
    }
}
