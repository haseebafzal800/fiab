<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a href="javascript:void(0)">
            <div class="image image-circle image-mini me-3">
                <img src="{{$row->visitDoctor->user->profile_image}}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            <div class="d-inline-block align-top">
                <div class="d-inline-block align-self-center d-flex">
                    <a class="mb-1 text-decoration-none fs-6">
                        {{$row->visitDoctor->user->full_name}}
                    </a>
                    <div class="star-ratings d-inline-block align-self-center ms-2">
                        <div class="avg-review-star-div d-flex align-self-center mb-1">
                            @if($row->visitDoctor->reviews->avg('rating') != 0)
                                @php
                                    $rating = $row->visitDoctor->reviews->avg('rating')
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
            </div>
            <span class="fs-6">{{$row->visitDoctor->user->email}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <span class="badge bg-primary">{{ \Carbon\Carbon::parse($row->visit_date)->isoFormat('DD MMM YYYY') }}</span>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="d-flex justify-content-center">
        <a href="{{ route('patients.patient.visits.show', $row->id) }}" title="{{ __('messages.common.show') }}" class="btn px-1 text-primary fs-3 user-edit-btn" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.show') }}">
            <i class="fas fa-eye"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>
