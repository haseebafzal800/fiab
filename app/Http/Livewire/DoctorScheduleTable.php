<?php

namespace App\Http\Livewire;

use App\Models\DoctorSession;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DoctorScheduleTable extends LivewireTableComponent
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
            Column::make(__('messages.doctor.doctor'), 'doctor.user.first_name')
                ->sortable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('doctor.user', function (Builder $q) use ($direction) {
                            $q->orderBy(User::select('first_name')->whereColumn('users.id', 'user_id'), $direction);
                        });
                    }
                )->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('doctor.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                ),
            Column::make(__('messages.doctor_session.session_meeting_time'),
                'session_meeting_time')->addClass('custom-center')
                ->sortable()->searchable(),
            Column::make(__('messages.common.action'))->addClass('w-100px text-center'),
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = DoctorSession::with(['doctor.user', 'doctor.reviews']);

        if (getLoginUser()->hasRole('doctor')) {
            $query->where('doctor_id', getLoginUser()->doctor->id);
        }

        return $query;
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.doctor_schedule_table';
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
                'componentName' => 'doctor_sessions.add_button',
            ]);
    }
}
