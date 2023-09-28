<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\State;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CityTable extends LivewireTableComponent
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
     * @return Builder
     */
    public function query(): Builder
    {
        return City::with('state');
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
                'componentName' => 'cities.add_button',
            ]);
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), 'name')
                ->sortable()->searchable(),
            Column::make(__('messages.city.state'), 'state.name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(State::select('name')->whereColumn('id', 'state_id'),
                        $direction);
                })->searchable(),
            Column::make(__('messages.common.action'))->addClass('w-100px text-center'),
        ];
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.city_table';
    }
}
