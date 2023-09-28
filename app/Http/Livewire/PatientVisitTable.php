<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PatientVisitTable extends LivewireTableComponent
{
    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @var string[]
     */
    protected $listeners = [
        'resetPage',
    ];

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('messages.visit.doctor'), 'visitDoctor.user.first_name')
                ->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('visitDoctor.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                )
                ->sortable(function (Builder $query) {
                    return $query->whereHas('visitDoctor', function (Builder $q) {
                        $q->orderBy(User::select('first_name')->where('id', 'visitDoctor.user_id'));
                    });
                }),
            Column::make(__('messages.visit.visit_date'), 'visit_date')
                    ->sortable(),
            Column::make(__('messages.common.action'))
                ->addClass('w-50px text-center'),
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
            ]);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Visit::with('visitDoctor.user', 'visitDoctor.reviews')->where('patient_id', getLoginUser()->patient->id);
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.patient_visit_table';
    }
}
