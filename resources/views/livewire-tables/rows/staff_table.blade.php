<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="{{route('staffs.show', $row->id)}}">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->profile_image}}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <a href="{{route('staffs.show', $row->id)}}" class="mb-1 text-decoration-none fs-6">
                {{$row->full_name}}
            </a>
            <span class="fs-6">{{$row->email}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->role_name }}
</x-livewire-tables::bs5.table.cell>


<x-livewire-tables::bs5.table.cell>
    <div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
        <input class="form-check-input h-20px w-30px staff-email-verified" data-id="{{ $row->id}}" type="checkbox"
               value=""
            {{ !empty($row->email_verified_at) ? 'checked disabled' : ''}}/>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
        <div class="d-flex justify-content-center">
            <a href="{{ route('staffs.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"
               class="btn px-2 text-primary fs-2 user-edit-btn" data-id="{{$row->id}}"  data-bs-toggle="tooltip"
               data-bs-original-title="{{ __('messages.common.edit') }}">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
               class="btn px-2 text-danger fs-2 staff-delete-btn"  data-bs-toggle="tooltip"
               data-bs-original-title="{{ __('messages.common.delete') }}">
                <i class="fa-solid fa-trash"></i>
            </a>
        </div>
</x-livewire-tables::bs5.table.cell>
