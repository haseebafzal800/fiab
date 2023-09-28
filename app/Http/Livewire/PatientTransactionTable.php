<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PatientTransactionTable extends LivewireTableComponent
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
            Column::make(__('messages.appointment.date'), 'created_at')
                ->sortable()->searchable(),
            Column::make(__('messages.appointment.payment_method'), 'type')
                ->sortable(),
            Column::make(__('messages.doctor_appointment.amount'), 'amount')
                ->sortable()->searchable()->addClass('d-flex justify-content-end'),
            Column::make(__('messages.common.action'))->addClass('w-50px text-center'),
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Transaction::where('user_id', '=', getLogInUserId());
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.patient_transaction_table';
    }
}
