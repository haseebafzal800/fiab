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
        @php
            $patientUrl = getLogInUser()->hasRole('doctor') ? route('doctors.patient.detail', $row->patient->id) 
                                                            : 'javascript:void(0)';
            $appointmentUrl  = getLogInUser()->hasRole('doctor') ? route('doctors.appointment.detail', $row->id) 
                                                                 : route('patients.appointment.detail', $row->id);
        @endphp
    <div class="d-flex align-items-center">
        <a href="javascript:void(0)">
            <div class="image image-circle image-mini me-3">
                <img src="{{ $row->patient->profile}}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            @if(getLogInUser()->hasRole('clinic_admin'))
            <a href="{{route('patients.show', $row->patient->id)}}" class="mb-1 text-decoration-none fs-6">
                {{$row->patient->user->full_name}}
            </a>
            @else
                <a href="{{$patientUrl}}" class="mb-1 text-decoration-none fs-6">
                    {{$row->patient->user->full_name}}
                </a>
            @endif
            <span class="fs-6"> {{$row->patient->user->email}}</span>
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
    
    <div class="w-150px d-flex align-items-center m-auto">
        <span class="slot-color-dot badge bg-{{getBadgeStatusColor($row->status)}} badge-circle me-2"></span>
        <select
            class="form-select io-select2 doctor-show-apptment-status doctor-show-apptment-status"
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
        @if(getLogInUser()->hasRole('clinic_admin'))
            <a href="{{ route('appointments.show', $row->id) }}" title="{{ __('messages.common.show') }}" data-bs-toggle="tooltip"
               data-bs-original-title="{{ __('messages.common.show') }}"
               class="btn px-2 text-primary fs-2 user-edit-btn" data-id="{{$row->id}}">
                <i class="fas fa-eye"></i>
            </a>
        @else
            <a href="{{ $appointmentUrl }}" title="{{ __('messages.common.show') }}" data-bs-toggle="tooltip"
               data-bs-original-title="{{ __('messages.common.show') }}"
               class="btn px-2 text-primary fs-2 user-edit-btn" data-id="{{$row->id}}">
                <i class="fas fa-eye"></i>
            </a>
        @endif
        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.delete') }}"
           class="btn px-2 text-danger fs-2 doctor-show-apptment-delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>
