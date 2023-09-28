<x-livewire-tables::bs5.table.cell>
    {{isset($row->name) ? $row->name :  __('messages.common.n/a') }}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    <span class="badge bg-primary me-2">{{ \Carbon\Carbon::parse($row->date)->isoFormat('DD MMM YYYY') }}</span>
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
       data-bs-toggle="tooltip"
       data-bs-original-title="{{ __('messages.common.delete') }}"
       class="btn px-1 text-danger fs-3 holiday-delete-btn">
        <i class="fa-solid fa-trash"></i>
    </a>
</x-livewire-tables::bs5.table.cell>
