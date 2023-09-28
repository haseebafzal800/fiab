<?php

namespace App\Http\Livewire;

use App\Models\LiveConsultation;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class LiveConsultationsTable extends LivewireTableComponent
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
            Column::make(__('messages.live_consultation.consultation_title'), 'consultation_title')
                ->sortable()->searchable(),
            Column::make(__('messages.appointment.date'), 'consultation_date')
                ->sortable(),
            Column::make(__('messages.live_consultation.created_by'), 'user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('users.id', 'created_by'),
                        $direction);
                })->searchable(),
            Column::make(__('messages.live_consultation.created_for'), 'doctor.user.first_name'),
            Column::make(__('messages.appointment.patient'), 'patient.user.full_name'),
            Column::make(__('messages.doctor.status'), 'status'),
            Column::make(__('messages.patient.password'), 'password')
                ->sortable()->searchable(),
            Column::make(__('messages.common.action'))
                ->addClass('w-100px text-center'),
        ];
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
     * @return Builder
     */
    public function query(): Builder
    {
        $query = LiveConsultation::with('patient.user', 'doctor.user', 'user');

        $query->when($this->statusFilter !== '' && $this->statusFilter != LiveConsultation::ALL,
            function (Builder $query) {
                $query->where('status', $this->statusFilter);
            });

        if (getLogInUser()->hasRole('patient')) {
            $query->where('patient_id', getLoginUser()->patient->id)->select('live_consultations.*');
        }

        if (getLogInUser()->hasRole('doctor')) {
            $query->where('doctor_id', getLoginUser()->doctor->id)->select('live_consultations.*');
        }

        return $query;
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $status = LiveConsultation::status;

        return view('livewire-tables::'.config('livewire-tables.theme').'.datatable')
            ->with([
                'columns' => $this->columns(),
                'rowView' => $this->rowView(),
                'filtersView' => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows' => $this->rows,
                'modalsView' => $this->modalsView(),
                'bulkActions' => $this->bulkActions,
                'filterComponent' => 'live_consultations.filter',
                'componentName' => 'live_consultations.add_button',
                'status' => $status,
                'filter' => $this->statusFilter,
            ]);
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.live_consultancy_table';
    }
}
