<div class="ms-auto">
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
                           placeholder="Pick date range" id="holidayDateFilter"/>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-5">{{__('messages.common.apply')}}</button>
                    <button type="reset" class="btn btn-secondary"
                            id="resetHolidayFilterBtn">{{__('messages.common.reset')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<a type="button" class="btn btn-primary"
   href="{{route('holidays.create')}}">
    {{__('messages.holiday.add_holiday')}}
</a>
