<x-livewire-tables::bs5.table.cell>
    <a href="javascript:void(0)" class="consultation-show-data text-decoration-none" data-id="{{$row->id}}">
        {{ $row->consultation_title }}
    </a>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if( $row->consultation_date == null )
        N/A
    @endif
    <div class="badge bg-primary">
        <div class="mb-2">
            {{ \Carbon\Carbon::parse($row->consultation_date)->isoFormat('h: m A') }}
        </div>
        <div>
            {{ \Carbon\Carbon::parse($row->consultation_date)->isoFormat('DD MMM YYYY') }}
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if(!empty($row->user->full_name))
        {{ $row->user->full_name }}
    @else
        N/A
    @endif
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->doctor->user->full_name }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->patient->user->full_name }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @php
        $colors = [
            'warning',
            'danger',
            'success'
        ]
    @endphp
    @if( auth()->user()->hasAnyRole('doctor', 'admin') )
        <div class="d-flex align-items-center">
            <span class="slot-color-dot badge bg-{{ $colors[$row->status] }} badge-circle me-2"></span>
            <select class="io-select2 form-select consultation-change-status"
                    data-id="{{ $row->id }}" data-control="select2">
                <option value="0" {{ $row->status == 0 ? 'selected' : '' }} {{ $row->status == 1 || $row->status == 2 ? 'disabled' : '' }}>
                    {{ __('messages.filter.awaited') }}
                </option>
                <option value="1" {{ $row->status == 1 ? 'selected' : '' }} {{ $row->status == 2 ? 'disabled' : '' }}>
                    {{ __('messages.filter.cancelled') }}
                </option>
                <option value="2" {{ $row->status == 2 ? 'selected' : '' }} {{ $row->status == 1 ? 'disabled' : '' }}>
                    {{ __('messages.filter.finished') }}
                </option>
            </select>
        </div>
    @else
        @if( $row->status == 1 )
            <span class="badge bg-danger">{{ __('messages.filter.cancelled') }}</span>
        @elseif( $row->status == 0 )
            <span class="badge bg-warning">{{ __('messages.filter.awaited') }}</span>
        @else
            <span class="badge bg-success">{{ __('messages.filter.finished') }}</span>
        @endif
    @endif
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->password }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
            @if( $row->status == 0 )
            <a href="javascript:void(0)" title="{{ getLogInUser()->hasRole('patient') ? 'Join Meeting' : 'Start Meeting' }}"
               class="btn px-2 text-primary fs-2 start-btn" data-id="{{$row->id}}">
                <i class="fa-solid fa-video"></i>
            </a>
            @endif
            @if(getLogInUser()->hasRole('doctor') )
                @if( $row->status != 2 )
                    <a href="javascript:void(0)" title="{{ __('messages.common.edit') }}" class="btn px-2 text-primary fs-2 live-consultation-edit-btn" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.edit') }}" data-id="{{$row->id}}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    @endif
            <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"  data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.delete') }}"
               class="btn px-2 text-danger fs-2 live-consultation-delete-btn">
                <i class="fa-solid fa-trash"></i>
            </a>
            @endif
    </div>
</x-livewire-tables::bs5.table.cell>
