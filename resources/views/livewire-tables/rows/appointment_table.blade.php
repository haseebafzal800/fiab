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
        <a href="{{route('doctors.show', $row->doctor->id)}}">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->doctor->user->profile_image}}" alt="" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <div class="d-inline-block align-top">
                <div class="d-inline-block align-self-center d-flex">
                    <a href="{{route('doctors.show', $row->doctor->id)}}" class="mb-1 text-decoration-none fs-6">
                        {{$row->doctor->user->full_name}}
                    </a>
                    <div class="star-ratings d-flex align-self-center ms-2">
                        @if($row->doctor->reviews->avg('rating') != 0)
                            @php
                                $rating = $row->doctor->reviews->avg('rating')
                            @endphp
                            @foreach(range(1, 5) as $i)
                                <div class="avg-review-star-div d-flex align-self-center mb-1">
                                    @if($rating > 0)
                                        @if($rating > 0.5)
                                            <i class="fas fa-star review-star"></i>
                                        @else
                                            <i class="fas fa-star-half-alt review-star"></i>
                                        @endif
                                    @else
                                        <i class="far fa-star review-star"></i>
                                    @endif
                                </div>
                                @php $rating-- @endphp
                            @endforeach
                        @else
                            @foreach(range(1, 5) as $i)
                                <div class="avg-review-star-div d-flex align-self-center mb-1">
                                    <i class="far fa-star review-star"></i>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <span class="fs-6">{{$row->doctor->user->email}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="{{route('patients.show', $row->patient->id)}}">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->patient->profile}}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <a href="{{route('patients.show', $row->patient->id)}}" class="mb-1 text-decoration-none fs-6">
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
    <select class="io-select2 form-select appointment-change-payment-status payment-status"
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
        <select class="io-select2 form-select appointment-status-change appointment-status"
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
        <a href="{{ route('appointments.show', $row->id) }}"
           class="btn px-1 text-primary fs-3" data-bs-toggle="tooltip"
               data-bs-original-title="{{ __('messages.common.view') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="javascript:void(0)" data-id="{{ $row->id }}" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.delete') }}"
           class="btn px-1 text-danger fs-3 appointment-delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>
