<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="javascript:void(0)">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->doctor->user->profile_image}}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <div class="d-inline-block align-top">
                <div class="d-inline-block align-self-center d-flex">
            <a href="{{route('doctors.show', $row->doctor_id)}}" class="mb-1 text-decoration-none fs-6">
                {{$row->doctor->user->full_name}}
            </a>
            <div class="mb-1 star-ratings d-flex align-self-center ms-2">
                @if($row->doctor->reviews->avg('rating') != 0)
                    @php
                        $rating = $row->doctor->reviews->avg('rating');
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
                            <i class="far fa-star review-star"></i>
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
    @if($row->session_meeting_time >= 60)
        <span class="badge bg-primary">{{ intdiv($row->session_meeting_time, 60).':'. ($row->session_meeting_time % 60)." ".__('messages.common.hour') }}</span>
    @else
        <span class="badge bg-primary">{{ $row->session_meeting_time." ".__('messages.common.minutes') }}</span>
    @endif
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        <a href="{{ route('doctor-sessions.edit', $row->id) }}" title="{{ __('messages.common.edit') }}" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.edit') }}"
           class="btn px-1 text-primary fs-3 user-edit-btn" data-id="{{$row->id}}">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.delete') }}"
           class="btn px-1 text-danger fs-3 doctor-session-delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>
