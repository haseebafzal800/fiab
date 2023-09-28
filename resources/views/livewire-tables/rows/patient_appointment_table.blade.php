@php
    use App\Models\Appointment;$book = Appointment::BOOKED;
    $allPaymentCount = Appointment::ALL_PAYMENT;
    $checkIn =  Appointment::CHECK_IN;
    $checkOut =  Appointment::CHECK_OUT;
    $cancel =  Appointment::CANCELLED;
    $pending = Appointment::PENDING;    
    $paid = Appointment::PAID;
    $paymentStatus = getAllPaymentStatus();
    $paymentGateway = getPaymentGateway()
@endphp
<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="javascript:void(0)">
            <div class="image image-circle image-mini me-3">
                <img src="{{ $row->doctor->user->profile_image}}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <a href="javascript:void(0)" class="mb-1 text-decoration-none fs-6">
                {{$row->doctor->user->full_name}}
            </a>
            <span class="fs-6">{{$row->doctor->user->email}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="badge bg-info">
        <div class="mb-2">{{$row->from_time}} {{ $row->from_time_type }}
            - {{$row->to_time}} {{ $row->to_time_type}}</div>
        <div class="">{{ \Carbon\Carbon::parse($row->date)->isoFormat('DD MMM YYYY') }}
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
   

    <span> {{getCurrencyFormat(getCurrencyCode(),$row->payable_amount)}}</span>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if ($row->payment_type === 2)
        
        <span class="badge bg-success">{{__('messages.transaction.'.strtolower( \App\Models\Appointment::PAYMENT_TYPE[$paid]))}}</span>
    @else
        <span class="badge bg-danger">{{__('messages.transaction.'.strtolower( \App\Models\Appointment::PAYMENT_TYPE[$pending]))}}</span>
        <a href="javascript:void(0)" data-id="{{$row->id}}"
           class="btn btn-icon payment-btn fs-3 py-1 mt-1"
           title="Appointment Payment">
            <i class="far fa-credit-card"></i>
        </a>
    @endif
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="w-120px d-flex align-items-center">
        <span class="badge bg-{{ getBadgeStatusColor($row->status) }} badge-circle slot-color-dot me-2"></span>
        <span class="">{{__('messages.common.'.strtolower(\App\Models\Appointment::STATUS[$row->status]))}}</span>
        
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        @if($row->status !== $cancel && $row->status !== $checkOut)
            <a href="javascript:void(0)" data-id="{{$row->id}}"
               class="btn px-1 text-danger fs-3 edit-btn patient-cancel-appointment" data-bs-toggle="tooltip"
               data-bs-original-title="Cancel Appointment"
               data-bs-custom-class="tooltip-dark" data-bs-placement="bottom" title="{{__('messages.appointment.cancel_appointment')}}">
                <i class="fas fa-calendar-times"></i>
            </a>
        @endif

        <a href="{{ route('patients.appointment.detail', $row->id) }}" title="{{ __('messages.common.show') }}" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.show') }}"
           class="btn px-1 text-primary fs-3 user-edit-btn" data-id="{{$row->id}}">
            <i class="fa-solid fa-eye"></i>
        </a>
        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.delete') }}"
           class="btn px-1 text-danger fs-3 doctor-panel-delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>
