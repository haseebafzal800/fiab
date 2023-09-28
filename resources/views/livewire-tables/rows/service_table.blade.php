<x-livewire-tables::bs5.table.cell>
    <div class="image image-circle image-mini me-3">
        <img src="{{ $row->icon }}" class="user-img">
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->name }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->serviceCategory->name }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="float-end">
        {{getCurrencyFormat(getCurrencyCode(),$row->charges)}}
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="form-check form-switch form-check-custom form-check-solid float-end">
        <input class="form-check-input h-20px w-30px service-statusbar" data-id="{{$row->id}}" type="checkbox"
               id="flexSwitch20x30" value=""
            {{$row->status === 1?'checked':''}} />
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        <a href="{{ route('services.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"
           class="btn px-2 text-primary fs-2  edit-btn" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.edit') }}" data-id="{{$row->id}}">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"  data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.delete') }}"
           class="btn px-2 text-danger fs-2 service-delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>
