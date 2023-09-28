<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AppointmentTable extends LivewireTableComponent
{
    public $statusFilter = Appointment::BOOKED;

    public $paymentTypeFilter = '';

    public $paymentStatusFilter = '';

    public $dateFilter = '';

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh', 'changeStatusFilter', 'changePaymentTypeFilter', 'changeDateFilter', 'resetPage',
    ];

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = Appointment::with([
            'doctor.user', 'patient.user', 'services', 'transaction', 'doctor.reviews', 'doctor.user.media',
        ]);

        $query->when($this->statusFilter != '' && $this->statusFilter != Appointment::ALL_STATUS,
            function (Builder $q) {
                if ($this->statusFilter != Appointment::ALL) {
                    $q->where('appointments.status', '=', $this->statusFilter);
                }
            });

        $query->when($this->paymentTypeFilter != '' && $this->paymentTypeFilter != Appointment::ALL_PAYMENT,
            function (Builder $q) {
                $q->where('payment_type', '=', $this->paymentTypeFilter);
            });

        $query->when($this->paymentStatusFilter != '',
            function (Builder $q) {
                if ($this->paymentStatusFilter != Appointment::ALL_PAYMENT) {
                    if ($this->paymentStatusFilter == Appointment::PENDING) {
                        $q->has('transaction', '=', null);
                    } elseif ($this->paymentStatusFilter == Appointment::PAID) {
                        $q->has('transaction', '!=', null);
                    }
                }
            });

        if ($this->dateFilter != '' && $this->dateFilter != getWeekDate()) {
            $timeEntryDate = explode(' - ', $this->dateFilter);
            $startDate = Carbon::parse($timeEntryDate[0])->format('Y-m-d');
            $endDate = Carbon::parse($timeEntryDate[1])->format('Y-m-d');
            $query->whereBetween('date', [$startDate, $endDate]);
        } else {
            $timeEntryDate = explode(' - ', getWeekDate());
            $startDate = Carbon::parse($timeEntryDate[0])->format('Y-m-d');
            $endDate = Carbon::parse($timeEntryDate[1])->format('Y-m-d');
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if (getLoginUser()->hasRole('patient')) {
            $query->where('patient_id', getLoginUser()->patient->id);
        }

        return $query;
    }

    /**
     * @param $status
     */
    public function changeStatusFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage($this->pageName());
    }

    /**
     * @param $type
     */
    public function changePaymentTypeFilter($type)
    {
        $this->paymentTypeFilter = $type;
        $this->resetPage($this->pageName());
    }

    /**
     * @param $date
     */
    public function changeDateFilter($date)
    {
        $this->dateFilter = $date;
        $this->resetPage($this->pageName());
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $appointmentStatus = Appointment::ALL_STATUS;
        $filter = ['date' => $this->dateFilter, 'paymentType' => $this->paymentTypeFilter, 'status' => $this->statusFilter];

        return view('livewire-tables::'.config('livewire-tables.theme').'.datatable')
            ->with([
                'columns' => $this->columns(),
                'rowView' => $this->rowView(),
                'filtersView' => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows' => $this->rows,
                'modalsView' => $this->modalsView(),
                'bulkActions' => $this->bulkActions,
                'componentFilter' => 'appointments.filter',
                'componentName' => 'appointments.add_button',
                'appointmentStatus' => $appointmentStatus,
                'filter' => $filter,
            ]);
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('messages.visit.doctor'), 'doctor.user.first_name')
                ->sortable(
                    function (Builder $query, $direction) {
                        return $query->leftJoin('doctors', 'appointments.doctor_id', 'doctors.id')
                            ->leftJoin('users', 'users.id', '=', 'doctors.user_id')
                            ->orderBy('users.first_name', $direction);
                    }
                )
                ->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('doctor.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                ),
            Column::make(__('messages.appointment.patient'), 'patient.user.first_name')
                ->sortable(
                    function (Builder $query, $direction) {
                        return $query->leftJoin('patients', 'appointments.patient_id', 'patients.id')
                            ->leftJoin('users', 'users.id', '=', 'patients.user_id')
                            ->orderBy('users.first_name', $direction);
                    }
                )->searchable(),
            Column::make(__('messages.appointment.appointment_at'), 'date')
                ->sortable()->searchable(),
            Column::make(__('messages.appointment.payment'))->addClass('text-center'),
            Column::make(__('messages.appointment.status'))->addClass('text-center'),
            Column::make(__('messages.common.action'))->addClass('w-100px text-center'),
        ];
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.appointment_table';
    }
}
