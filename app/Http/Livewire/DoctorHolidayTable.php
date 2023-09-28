<?php

namespace App\Http\Livewire;

use App\Models\DoctorHoliday;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DoctorHolidayTable extends LivewireTableComponent
{
    public $dateFilter = '';

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @var string[]
     */
    public function changeDateFilter($date)
    {
        $this->dateFilter = $date;
        $this->resetPage($this->pageName());
    }

    protected $listeners = [
        'refresh' => '$refresh', 'resetPage', 'changeDateFilter',
    ];

    public function columns(): array
    {
        return [
            Column::make(__('messages.visit.doctor'), 'doctor.user.first_name')
                ->sortable(
                    function (Builder $query, $direction) {
                        return $query->leftJoin('doctors', 'doctor_holidays.doctor_id', 'doctors.id')
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

            Column::make(__('messages.web.reason'), 'name')
                ->sortable()->addClass('w-50'),
            Column::make(__('messages.holiday.holiday_date'), 'date')
                ->sortable(),
            Column::make(__('messages.common.action'), 'id'),
        ];
    }

    public function render()
    {
        $status = DoctorHoliday::ALL_STATUS;
        $filter = ['date' => $this->dateFilter];

        return view('livewire-tables::'.config('livewire-tables.theme').'.datatable')
            ->with([
                'columns' => $this->columns(),
                'rowView' => $this->rowView(),
                'filtersView' => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows' => $this->rows,
                'modalsView' => $this->modalsView(),
                'bulkActions' => $this->bulkActions,
                'componentName' => 'doctor_holiday.add_button',
                'status' => $status,
                'resetPage' => $this->resetPage($this->pageName()),
                'filter' => $filter,
            ]);
    }

    public function query(): Builder
    {
        $query = DoctorHoliday::with('doctor.user');

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

        return $query;
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.doctor_holiday_table';
    }
}
