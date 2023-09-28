<div class="ms-auto">
    <div class="dropdown d-flex align-items-center me-4 me-md-2">
        <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button" id="filterBtn"                           data-bs-toggle="dropdown" aria-expanded="false">
            <p class="text-center">
                <i class='fas fa-filter'></i>
            </p>
        </button>
        <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton1">
            <div class="text-start border-bottom py-4 px-7">
                <h3 class="text-gray-900 mb-0">{{__('messages.common.filter_option')}}</h3>
            </div>
            <div class="p-5">
                <div class="mb-10">
                    <label class="form-label fw-bold">{{__('messages.appointment.date')}}</label>
                    <div>
                        <input class="form-control form-control-solid"
                               placeholder="Pick date range"
                               id="patientAppointmentDate"/>
                    </div>
                </div>
                <div class="mb-10">
                    <label class="form-label fw-bold">{{__('messages.appointment.payment')}}</label>
                    <div>
                        {{ Form::select('payment_type', \App\Models\Appointment::PAYMENT_TYPE_ALL, \App\Models\Appointment::ALL_PAYMENT,['class' => 'form-control form-control-solid form-select', 'data-control'=>"select2", 'id' => 'patientPaymentStatus']) }}
                    </div>
                </div>
                <div class="mb-5">
                    <label for="filterBtn" class="form-label">{{__('messages.doctor.status')}}:</label>
                    {{ Form::select('status',  $appointmentStatus, \App\Models\Appointment::BOOKED, ['class' => 'form-select io-select2', 'data-control'=>"select2", 'id' => 'patientShowPageAppointmentStatus']) }}
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-5">{{__('messages.common.apply')}}</button>
                    <button type="reset" class="btn btn-secondary" id="doctorResetFilter">{{__('messages.common.reset')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
