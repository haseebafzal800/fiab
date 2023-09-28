<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DoctorsTransactionTable extends LivewireTableComponent
{
    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh', 'resetPage',
    ];

    public function columns(): array
    {
        return [
            Column::make(__('messages.appointment.patient'), 'user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('users.id', 'user_id'), $direction);
                })->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                ),
            Column::make(__('messages.appointment.date'), 'created_at')
                ->sortable(),
            Column::make(__('messages.appointment.payment_method'), 'type')
                ->sortable()->searchable(),
            Column::make(__('messages.doctor_appointment.amount'), 'amount')
                ->sortable()->searchable()->addClass('d-flex justify-content-end'),
            Column::make(__('messages.common.action'))->addClass('w-100px text-center'),

        ];
    }

    public function query(): Builder
    {
        $transaction = Transaction::whereHas('doctorappointment')
            ->with(['doctorappointment', 'user.patient','appointment'])
            ->whereType(Appointment::MANUALLY);

        return $transaction;
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.doctors_transaction_table';
    }
}
