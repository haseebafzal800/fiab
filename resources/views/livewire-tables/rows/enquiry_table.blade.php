<x-livewire-tables::table.cell>
    {{ $row->name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ Str::limit($row->message, 55) }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if($row->view)
        <div class="badge bg-success">{{ __('messages.common.read') }}</div>
    @else
        <div class="badge bg-danger">{{ __('messages.common.unread') }}</div>
    @endif
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="badge bg-primary">{{ \Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM YYYY h:m A') }}</div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        <a href="{{ route('enquiries.show', $row->id) }}"
           class="btn px-1 text-primary fs-3" data-bs-toggle="tooltip"
               data-bs-original-title="{{ __('messages.common.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"  data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.delete') }}"
           class="btn px-1 text-danger fs-3 enquiry-delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>

