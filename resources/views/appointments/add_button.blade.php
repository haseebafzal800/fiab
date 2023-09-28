<div class="row ms-auto">
    <div class="col-md-12">
        <div class="d-flex align-items-center">
            <span class="badge bg-primary badge-circle me-1 slot-color-dot"></span>
            <span class="me-4">{{__('messages.common.'.strtolower(\App\Models\Appointment::STATUS[1]))}}</span>
            <span class="badge bg-success badge-circle me-1 slot-color-dot"></span>
            <span class="me-4">{{__('messages.common.'.strtolower(\App\Models\Appointment::STATUS[2]))}}</span>
            <span class="badge bg-warning badge-circle me-1 slot-color-dot"></span>
            <span class="me-4">{{__('messages.common.'.strtolower(\App\Models\Appointment::STATUS[3]))}}</span>
            <span class="badge bg-danger badge-circle me-1 slot-color-dot"></span>
            <span class="me-4">{{__('messages.common.'.strtolower(\App\Models\Appointment::STATUS[4]))}}</span>
        </div>
    </div>
</div>
<a href="{{ route('appointments.calendar') }}"
   class="btn btn-icon btn-primary me-2">
    <i class="fas fa-calendar-alt fs-3"></i>
</a>
<div class="dropdown d-flex align-items-center me-4 me-md-2">
    <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button" id="filterBtn"                           data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
        <p class="text-center">
            <i class='fas fa-filter'></i>
        </p>
    </button>
    <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton1">
        <div class="text-start border-bottom py-4 px-7">
            <h3 class="text-gray-900 mb-0">{{__('messages.common.filter_option')}}</h3>
        </div>
        <div class="p-5">
            <div class="mb-5">
                <label for="filterBtn" class="form-label">{{__('messages.appointment.date')}}:</label>
                <input class="form-control form-control-solid" value="{{$filter['date']}}"
                       placeholder="Pick date range" id="appointmentDateFilter"/>
            </div>
            <div class="mb-5">
                <label for="filterBtn" class="form-label">{{ __('messages.appointment.payment') }}:</label>
                {{ Form::select('payment_type', filterLangChange(\App\Models\Appointment::PAYMENT_TYPE_ALL), $filter['paymentType'],['class' => 'form-control form-control-solid form-select', 'data-control'=>"select2", 'id' => 'paymentStatus']) }}
            </div>
            <div class="mb-5">
                <label for="filterBtn" class="form-label">{{__('messages.doctor.status')}}:</label>
                {{ Form::select('status', filterLangChange($appointmentStatus),$filter['status'],['class' => 'form-control form-control-solid form-select', 'data-control'=>"select2", 'id' => 'appointmentStatus']) }}
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-5">{{__('messages.common.apply')}}</button>
                <button type="reset" class="btn btn-secondary" id="appointmentResetFilter">{{__('messages.common.reset')}}</button>
            </div>
        </div>
    </div>
</div>

<a type="button" class="btn btn-primary" href="{{ route('appointments.create')}}" data-turbo="false">
    {{ __('messages.appointment.add_new_appointment') }}
</a>
