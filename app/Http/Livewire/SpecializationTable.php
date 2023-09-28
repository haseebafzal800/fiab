<?php

namespace App\Http\Livewire;

use App\Models\Specialization;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SpecializationTable extends LivewireTableComponent
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
                    ->searchable(),
            Column::make(__('messages.common.action'))
                    ->addClass('text-center w-100px'),
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Specialization::query();
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
                'componentName' => 'specializations.add_button',
            ]);
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.specialization_table';
    }
}
