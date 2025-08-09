@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Schedules</h6>
                        <h3 class="mb-0">{{ App\Models\Schedule::count() }}</h3>
                    </div>
                    <i class='bx bx-calendar fs-1'></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Today's Schedules</h6>
                        <h3 class="mb-0">{{ App\Models\Schedule::whereDate('created_at', today())->count() }}</h3>
                    </div>
                    <i class='bx bx-calendar-check fs-1'></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Activities</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach(App\Models\Schedule::latest()->take(5)->get() as $schedule)
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $schedule->title ?? 'Schedule' }}</h6>
                            <small>{{ $schedule->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $schedule->description ?? 'No description available' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
