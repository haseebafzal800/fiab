<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DoctorVisitTable extends LivewireTableComponent
{
    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @var string[]
     */
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    /**
     *df
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('messages.visit.patient'), 'visitPatient.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->whereHas('visitPatient.user', function (Builder $q) use ($direction) {
                        $q->orderBy(User::select('first_name')->whereColumn('id', 'patients.user_id', $direction));
                    });
                })
                ->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('visitPatient.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                ),
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
        return Visit::with('visitPatient.user', 'visitDoctor.reviews')->where('doctor_id', getLoginUser()->doctor->id);
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.doctor_visit_table';
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
            ]);
    }
}
