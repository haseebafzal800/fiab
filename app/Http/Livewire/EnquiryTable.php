<?php

namespace App\Http\Livewire;

use App\Models\Enquiry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EnquiryTable extends LivewireTableComponent
{
    public $statusFilter = '';

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'changeFilter', 'resetPage',
    ];

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = Enquiry::query();

        $query->when($this->statusFilter !== '' && $this->statusFilter != Enquiry::ALL,
            function (Builder $query) {
                return $query->where('view', $this->statusFilter);
            });

        return $query;
    }

    /**
     * @param $value
     */
    public function changeFilter($value)
    {
        $this->statusFilter = $value;
        $this->resetPage($this->pageName());
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $status = Enquiry::VIEW_NAME;

        return view('livewire-tables::'.config('livewire-tables.theme').'.datatable')
            ->with([
                'columns' => $this->columns(),
                'rowView' => $this->rowView(),
                'filtersView' => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows' => $this->rows,
                'modalsView' => $this->modalsView(),
                'bulkActions' => $this->bulkActions,
                'componentName' => 'fronts.enquiries.filter',
                'status' => $status,
                'filter' => $this->statusFilter,
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
            Column::make(__('messages.web.message'), 'message')
                ->sortable()->searchable(),
            Column::make(__('messages.web.status'), 'view')
                ->sortable()->searchable(),
            Column::make(__('messages.doctor.created_at'), 'created_at')
                ->sortable()->searchable(),
            Column::make(__('messages.common.action'))->addClass('w-100px text-center'),
        ];
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.enquiry_table';
    }
}
