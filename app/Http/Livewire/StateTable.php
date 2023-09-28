<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Models\State;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StateTable extends LivewireTableComponent
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
                    ->sortable()
                    ->searchable()
                    ->addClass('text-center w-50'),
            Column::make(__('messages.state.country'), 'country.name')
                    ->addClass('text-start')
                    ->sortable(function (Builder $query, $direction) {
                        return $query->orderBy(Country::select('name')->whereColumn('id', 'country_id'), $direction);
                    })
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
                'componentName' => 'states.add_button',
            ]);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return State::with('country');
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.state_table';
    }
}
