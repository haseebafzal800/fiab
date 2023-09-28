<?php

namespace App\Http\Livewire;

use App\Models\Visit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class VisitTable extends LivewireTableComponent
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

            Column::make(__('messages.visit.doctor'), 'visitDoctor.user.first_name')
                ->sortable(
                    function (Builder $query, $direction) {
                        return $query->leftJoin('doctors', 'visits.doctor_id', 'doctors.id')
                            ->leftJoin('users', 'users.id', '=', 'doctors.user_id')
                            ->orderBy('users.first_name', $direction);
                    }
                )
                ->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('visitDoctor.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                ),
            Column::make(__('messages.visit.patient'), 'visitPatient.user.first_name')
                ->sortable(
                    function (Builder $query, $direction) {
                        return $query->leftJoin('patients', 'visits.patient_id', 'patients.id')
                            ->leftJoin('users', 'users.id', '=', 'patients.user_id')
                            ->orderBy('users.first_name', $direction);
                    }
                )
                ->searchable(),
            Column::make(__('messages.visit.visit_date'), 'visit_date')
                    ->sortable(),
            Column::make(__('messages.common.action'))
                    ->addClass('w-100px text-center'),
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Visit::with('visitDoctor.user', 'visitPatient.user', 'visitDoctor.reviews');
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
                'componentName' => 'visits.add_button',
                'resetPage' => $this->resetPage($this->pageName()),
            ]);
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.visit_table';
    }
}
