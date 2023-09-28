<?php

namespace App\Http\Livewire;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DoctorTable extends LivewireTableComponent
{
    public $statusFilter = '';

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    /**
     * @param $value
     */
    public function changeStatusFilter($value)
    {
        $this->statusFilter = $value;
        $this->resetPage($this->pageName());
    }

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'changeStatusFilter', 'resetPage',
    ];

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = Doctor::with(['user', 'specializations', 'reviews'])->select('doctors.*');

        $query->when($this->statusFilter != '' && $this->statusFilter != User::ALL,
            function (Builder $query) {
                return $query->whereHas('user', function (Builder $q) {
                    $q->where('status', $this->statusFilter);
                });
            });

        return $query;
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $status = User::STATUS;

        return view('livewire-tables::'.config('livewire-tables.theme').'.datatable')
            ->with([
                'columns' => $this->columns(),
                'rowView' => $this->rowView(),
                'filtersView' => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows' => $this->rows,
                'modalsView' => $this->modalsView(),
                'bulkActions' => $this->bulkActions,
                'componentFilter' => 'doctors.filter',
                'componentName' => 'doctors.add_button',
                'status' => $status,
                'filterStatus' => $this->statusFilter,
            ]);
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('messages.doctor.doctor'), 'user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('users.id', 'user_id'), $direction);
                })->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                ),
            Column::make(__('messages.doctor.status'), 'status')->addClass('text-start'),
            Column::make(__('messages.common.email_verified'), 'email_verified_at')->addClass('text-start'),
            Column::make(__('messages.common.impersonate'))->addClass('text-start'),
            Column::make(__('messages.patient.registered_on'), 'created_at')
                ->sortable(),
            Column::make(__('messages.common.action'))->addClass('w-100px text-center'),
        ];
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire-tables.rows.doctor_table';
    }
}
