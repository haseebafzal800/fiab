<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="{{route('patients.show', $row->id)}}">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->profile}}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <a href="{{route('patients.show', $row->id)}}" class="mb-1 text-decoration-none fs-6">
                {{$row->user->first_name.' '.$row->user->last_name}}
            </a>
            <span class="fs-6">{{$row->user->email}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="badge badge-circle bg-danger me-2">{{ $row->appointments_count }}</div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="form-check form-switch d-flex justify-content-center">
        <input class="form-check-input patient-email-verified" data-id="{{ $row->user->id }}"
               type="checkbox" value=""
            {{!empty($row->user->email_verified_at) ? 'checked disabled' : ''}} />
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <a data-turbo="false" title="Impersonate {{$row->user->full_name}}" class="btn btn-primary btn-sm me-5"
       style="width: fit-content;" href="{{route(
                        'impersonate', $row->user->id)}}">
        {{__('messages.common.impersonate')}}
    </a>
</x-livewire-tables::bs5.table.cell>


<x-livewire-tables::bs5.table.cell>
    <div class="badge bg-primary me-2">{{ \Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM YYYY h:m A') }}</div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        @if(empty($row->user->email_verified_at))
            <a href="javascript:void(0)" data-id="{{ $row->user->id }}"
               class="btn px-2 text-primary fs-2 patient-email-verification"  data-bs-toggle="tooltip"
               data-bs-original-title="{{__('messages.resend_email_verification')}}">
            <span class="svg-icon svg-icon-3">
                    <i class="fas fa-envelope"></i>
                </span>
            </a>
        @endif
            <a href="{{ route('patients.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"  data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.edit') }}"
               class="btn px-2 text-primary fs-2" data-turbolinks="false">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"  data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.delete') }}"
               class="btn px-2 text-danger fs-2 patient-delete-btn">
                <i class="fa-solid fa-trash"></i>
            </a>
    </div>
</x-livewire-tables::bs5.table.cell>
