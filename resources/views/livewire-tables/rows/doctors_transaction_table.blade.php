<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="{{ getLogInUser()->hasRole('doctor') ? url('doctors/patients-detail/'.$row->user->patient->id) : route('patients.show', $row->user->patient->id)}}">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->user->patient->profile}}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <a href="{{ getLogInUser()->hasRole('doctor') ? url('doctors/patients-detail/'.$row->user->patient->id) : route('patients.show', $row->user->patient->id)}}" class="mb-1 text-decoration-none fs-6">
                {{$row->user->first_name.' '.$row->user->last_name}}
            </a>
            <span class="fs-6">{{$row->user->email}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="badge bg-primary">{{ \Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM YYYY h:m A') }}</div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ \App\Models\Appointment::PAYMENT_METHOD[$row->type] }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="float-end">
        {{ getCurrencyFormat(getCurrencyCode(),$row->amount)}}
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>

    @if($row->appointment->status == \App\Models\Appointment::CANCELLED)
        <div class="d-flex justify-content-center">
            <a href="{{ route('doctors.transactions.show', $row->id) }}"
               class="btn px-1 text-danger fs-2" title="{{ __('messages.flash.appointment_cancel') }}" data-bs-toggle="tooltip"
               data-bs-original-title="{{ __('messages.common.show') }}">
                <i class="fa-regular fa-circle-xmark"></i>
            </a>
        </div>
    @elseif($row->status == \App\Models\Transaction::PENDING)
        <div class="form-check form-switch form-check-custom form-check-solid d-flex justify-content-center">
            <input class="form-check-input h-20px w-30px transaction-statusbar" data-id="{{$row->id}}" type="checkbox"
                   value=""
                {{$row->status === 1?'checked':''}} />
        </div>
    @else
        <div class="d-flex justify-content-center">
            <a href="{{ route('doctors.transactions.show', $row->id) }}"
               class="btn px-1 text-primary fs-3" title="{{ __('messages.common.show') }}" data-bs-toggle="tooltip"
               data-bs-original-title="{{ __('messages.common.show') }}">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    @endif
</x-livewire-tables::bs5.table.cell>
