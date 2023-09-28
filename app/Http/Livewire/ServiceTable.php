<?php

namespace App\Http\Livewire;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ServiceTable extends LivewireTableComponent
{
    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @var string
     */
    public $statusFilter = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'changeStatusFilter', 'resetPage',
    ];

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('messages.front_service.icon')),
            Column::make(__('messages.common.name'), 'name')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.service.category'), 'serviceCategory.name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(ServiceCategory::select('name')->whereColumn('id', 'category_id'),
                        $direction);
                })
                ->searchable(),
            Column::make(__('messages.appointment.service_charge'), 'charges')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy('charges', $direction);
                })->searchable()->addClass('d-flex justify-content-end'),
            Column::make(__('messages.doctor.status'), 'status')
                ->addClass('text-end'),
            Column::make(__('messages.common.action'))
                ->addClass('w-100px text-center'),

        ];
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $status = Service::STATUS;

        return view('livewire-tables::'.config('livewire-tables.theme').'.datatable')
            ->with([
                'columns' => $this->columns(),
                'rowView' => $this->rowView(),
                'filtersView' => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows' => $this->rows,
                'modalsView' => $this->modalsView(),
                'bulkActions' => $this->bulkActions,
                'componentFilter' => 'services.filter',
                'componentName' => 'services.add_button',
                'status' => $status,
            ]);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = Service::with('serviceCategory', 'media');

        $query->when($this->statusFilter !== '' && $this->statusFilter != Service::ALL,
            function (Builder $query) {
                $query->where('status', $this->statusFilter);
            });

        return $query;
    }

    /**
     * @param $value
     */
    public function changeStatusFilter($value)
    {
        $this->statusFilter = $value;
        $this->resetPage($this->pageName());
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.service_table';
    }
}
