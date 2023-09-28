<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="{{ getLogInUser()->hasRole('doctor') ? url('doctors/patients-detail/'.$row->patient_id) : route('patients.show', $row->patient_id)}}" class="mb-1 text-decoration-none fs-6">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->visitPatient->profile}}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <a href="{{ getLogInUser()->hasRole('doctor') ? url('doctors/patients-detail/'.$row->patient_id) : route('patients.show', $row->patient_id)}}" class="mb-1 text-decoration-none fs-6">
                {{$row->visitPatient->user->full_name}}
            </a>
            <span class="fs-6">{{$row->visitPatient->user->email}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <span class="badge bg-primary">{{ \Carbon\Carbon::parse($row->visit_date)->isoFormat('DD MMM YYYY') }}</span>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        <a href="{{ route('doctors.visits.show', $row->id) }}" title="{{ __('messages.common.show') }}"
           class="btn px-1 text-primary fs-3" data-bs-toggle="tooltip" data-bs-original-title="{{ __('messages.common.show') }}">
            <i class="fas fa-eye fs-4"></i>
        </a>
        <a href="{{ route('doctors.visits.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"
           class="btn px-1 text-primary fs-3  edit-btn" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.edit') }}" data-id="{{$row->id}}">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"  data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.edit') }}"
           class="btn px-1 text-danger fs-3 doctor-visit-delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>
