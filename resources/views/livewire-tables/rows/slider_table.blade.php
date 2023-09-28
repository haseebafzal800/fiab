<x-livewire-tables::table.cell>
    <div class="d-flex align-items-center">
        <div class="image image-circle image-mini me-3">
            <img src="{{ $row->slider_image }}" alt="user" class="user-img">
        </div>
    </div>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->title }}
</x-livewire-tables::table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->short_description }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        <a href="{{ route('sliders.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"  data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.edit') }}"
           class="btn px-1 text-primary fs-3" data-id="{{$row->id}}">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>

