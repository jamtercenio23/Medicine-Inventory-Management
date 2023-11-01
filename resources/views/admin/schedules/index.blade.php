@extends('layouts.app')
@section('title', 'Medicine Inventory - Schedules')
@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Barangay Distribution Schedules</h1>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h4><a href="{{ route('home') }}">Dashboard</a> / Schedules</h4>
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createScheduleModal">
            Add Schedule
        </button>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('schedules.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $query }}">
                            <div class="input-group-append">
                                <button class="btn btn-secondary btn" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <!-- Schedule Table -->
                <div class="table-responsive">
                    @if ($schedules->isEmpty())
                        <p>No schedules found.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Barangay</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->id }}</td>
                                        <td>{{ $schedule->barangay->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#showScheduleModal{{ $schedule->id }}">
                                                <i class="fas fa-eye"></i> Show</button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editScheduleModal{{ $schedule->id }}">
                                                <i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteScheduleModal{{ $schedule->id }}">
                                                <i class="fas fa-trash"></i> Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Show Schedule Modal -->
                                    @include('admin.schedules.show_modal', ['schedule' => $schedule])

                                    <!-- Edit Schedule Modal -->
                                    @include('admin.schedules.edit_modal', ['schedule' => $schedule])

                                    <!-- Delete Schedule Modal -->
                                    @include('admin.schedules.delete_modal', ['schedule' => $schedule])
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="float-left">
                    <!-- You can add any additional content here if needed -->
                </div>
                <div class="float-right">
                    <!-- Bootstrap Pagination -->
                    <ul class="pagination">
                        <li class="page-item {{ $schedules->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $schedules->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $schedules->lastPage(); $i++)
                            <li class="page-item {{ $i == $schedules->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $schedules->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $schedules->currentPage() == $schedules->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $schedules->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Create Schedule Modal -->
    @include('admin.schedules.create_modal')
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<!-- Include Bootstrap CSS for pagination styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
