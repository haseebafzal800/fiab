<?php

namespace App\Http\Livewire;

use App\Models\Doctor;
use App\Models\DoctorHoliday;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class HolidayTable extends LivewireTableComponent
{
    public $dateFilter = '';

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh', 'changeDateFilter',
    ];

    public function columns(): array
    {
        return [

            Column::make(__('messages.web.reason'), 'name')
                ->sortable()->addClass('w-75'),
            Column::make(__('messages.appointment.date'), 'date')
                ->sortable(),
            Column::make(__('messages.common.action'), 'id'),
        ];
    }

    public function changeDateFilter($date)
    {
        $this->dateFilter = $date;
        $this->resetPage($this->pageName());
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
                'componentName' => 'holiday.add_button',
                'status' => $status,
                'resetPage' => $this->resetPage($this->pageName()),
                'filter' => $filter,
            ]);
    }

    public function query(): Builder
    {
        $doctor = Doctor::whereUserId(getLogInUserId())->first('id');
        $doctorId = $doctor['id'];
        $query = DoctorHoliday::whereDoctorId($doctorId);

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
        return 'livewire-tables.rows.holiday_table';
    }
}
