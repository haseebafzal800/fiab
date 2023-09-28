@php
    $book = \App\Models\Appointment::BOOKED;
    $allPaymentCount = \App\Models\Appointment::ALL_PAYMENT;
    $checkIn =  \App\Models\Appointment::CHECK_IN;
    $checkOut =  \App\Models\Appointment::CHECK_OUT;
    $cancel =  \App\Models\Appointment::CANCELLED;
    $pending = \App\Models\Appointment::PENDING;
    $paid = \App\Models\Appointment::PAID;
    $paymentStatus = getAllPaymentStatus();
    $paymentGateway = getPaymentGateway();
@endphp
<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="{{ getLogInUser()->hasRole('doctor') ? url('doctors/patients-detail/'.$row->patient->id) : route('patients.show', $row->patient->id)}}">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->patient->profile}}" alt="" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <a href="{{ getLogInUser()->hasRole('doctor') ? url('doctors/patients-detail/'.$row->patient->id) : route('patients.show', $row->patient->id)}}" class="mb-1 text-decoration-none fs-6">
                {{$row->patient->user->full_name}}
            </a>
            <span class="fs-6">{{$row->patient->user->email}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="badge bg-primary">
        <div class="mb-2">{{$row->from_time}} {{ $row->from_time_type }}
            - {{$row->to_time}} {{ $row->to_time_type}}</div>
        <div class="">{{ \Carbon\Carbon::parse($row->date)->isoFormat('DD MMM YYYY') }}
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <span>{{getCurrencyFormat(getCurrencyCode(),$row->payable_amount)}}</span>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <select class="io-select2 form-select doctor-apptment-change-payment-status payment-status"
            data-control="select2"
            data-id="{{$row->id}}">
        <option value="{{ $paid }}" {{( $row->payment_type ==
                $paid) ? 'selected' : ''}}>{{__('messages.transaction.paid')}}
        </option>
        <option value="{{$pending}}" {{( $row->payment_type ==
                $paid) ? 'disabled' : 'selected'}}>{{ __('messages.transaction.pending')}}
        </option>
    </select>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <span class="slot-color-dot badge bg-{{getBadgeStatusColor($row->status)}} badge-circle me-2"></span>
        <select class="io-select2 form-select doctor-appointment-status-change appointment-status"
                data-control="select2"
                data-id="{{$row->id}}">
            <option class="booked" disabled value="{{ $book}}" {{$row->status ==
                    $book ? 'selected' : ''}}>{{__('messages.common.'.strtolower(\App\Models\Appointment::STATUS[1]))}}
            </option>
            <option value="{{ $checkIn}}" {{$row->status ==
                    $checkIn ? 'selected' : ''}} {{$row->status == $checkIn
            ? 'selected'
            : ''}} {{( $row->status == $cancel || $row->status == $checkOut)
            ? 'disabled'
            : ''}}>{{__('messages.common.'.strtolower(\App\Models\Appointment::STATUS[2]))}}
            </option>
            <option value="{{ $checkOut}}" {{$row->status ==
                    $checkOut ? 'selected' : ''}} {{($row->status == $cancel ||
            $row->status == $book) ? 'disabled' : ''}}>{{__('messages.common.'.strtolower(\App\Models\Appointment::STATUS[3]))}}
            </option>
            <option value="{{$cancel}}" {{$row->status ==
                    $cancel ? 'selected' : ''}} {{$row->status == $checkIn
            ? 'disabled'
            : ''}} {{$row->status == $checkOut ? 'disabled' : ''}}>{{__('messages.common.'.strtolower(\App\Models\Appointment::STATUS[4]))}}
            </option>
        </select>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        <a href="{{ route('doctors.appointment.detail', $row->id) }}" class="btn px-1 text-primary fs-3" title="{{ __('messages.common.show') }}" data-bs-toggle="tooltip"
               data-bs-original-title="{{ __('messages.common.show') }}">
            <i class="fas fa-eye"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>
