<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="{{route('doctors.show', $row->id)}}">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->user->profile_image}}" alt="" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <div class="d-inline-block align-top">
                <div class="d-inline-block align-self-center d-flex">
                    <a href="{{route('doctors.show', $row->id)}}" class="mb-1 text-decoration-none fs-6">
                        {{$row->user->full_name}}
                    </a>
                    <div class="star-ratings d-flex align-self-center ms-2">
                        @if($row->reviews->avg('rating') != 0)
                            @php
                                $rating = $row->reviews->avg('rating');
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
                                @php $rating--; @endphp
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
            <span class="fs-6">{{$row->user->email}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
        <input class="form-check-input h-20px w-30px doctor-status" data-id="{{$row->user->id}}" type="checkbox"
               id="flexSwitch20x30"
                {{ $row->user->status == 1 ? 'checked' : ''}}>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
        <input class="form-check-input h-20px w-30px doctor-email-verified" data-id="{{ $row->user->id }}"
               type="checkbox" value=""
            {{!empty($row->user->email_verified_at) ? 'checked disabled' : ''}} />
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if($row->user->status)
        <a data-turbo="false" title="Impersonate {{$row->user->full_name}}" class="btn btn-sm btn-primary me-5"
           style="width: fit-content;" href="{{route(
                        'impersonate', $row->user->id)}}">
            {{__('messages.common.impersonate')}}
        </a>
    @else
        <a data-turbo="false" title="Impersonate {{$row->user->full_name}}" class="btn btn-sm btn-secondary me-5"
           style="pointer-events: none; cursor: default;" href="{{route(
                        'impersonate', $row->user->id)}}">
            {{__('messages.common.impersonate')}}
        </a>
    @endif
</x-livewire-tables::bs5.table.cell>


<x-livewire-tables::bs5.table.cell>
    <div class="badge bg-primary">{{ \Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM YYYY h:m A') }}</div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        @if(empty($row->user->email_verified_at))
            <a href="#" data-id="{{ $row->user->id }}"
               class="btn px-2 text-primary fs-2 doctor-email-verification"
               data-bs-toggle="tooltip" data-bs-original-title="{{__('messages.resend_email_verification')}}">
            <span class="svg-icon svg-icon-3">
                    <i class="fas fa-envelope"></i>
                </span>
            </a>
        @endif

        <a data-id="{{ $row->user->id }}" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.doctor.add_qualification') }}"
           class="btn px-2 fs-2 add-qualification">
            <i class="fa-solid fa-plus"></i>
        </a>
        <a href="{{ route('doctors.edit', $row->id) }}" title="{{ __('messages.common.edit') }}" class="btn px-2 text-primary fs-2 doctor-edit-btn" data-bs-toggle="tooltip"
           data-bs-original-title="Edit" data-turbolinks="false">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}" class="btn px-2 text-danger fs-2 doctor-delete-btn" data-bs-toggle="tooltip"
           data-bs-original-title="Delete">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>
