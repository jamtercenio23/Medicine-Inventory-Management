@extends('layouts.app')

@section('title', 'Medicine Inventory - Patients')

@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Patients</h1>
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
        <h4><a href="{{ route('home') }}">Dashboard</a> / Patients</h4>
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createPatientModal">
            Add Patient
        </button>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('patients.index') }}" method="GET" class="form-inline">
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
                <!-- Patient Table -->
                <div class="table-responsive">
                    @if ($patients->isEmpty())
                        <p>No patients found.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $patient)
                                    <tr>
                                        <td>{{ $patient->id }}</td>
                                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#showPatientModal{{ $patient->id }}">
                                                <i class="fas fa-eye"></i> Show
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editPatientModal{{ $patient->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deletePatientModal{{ $patient->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Show Patient Modal -->
                                    @include('admin.patients.show_modal', ['patient' => $patient])

                                    <!-- Edit Patient Modal -->
                                    @include('admin.patients.edit_modal', ['patient' => $patient])

                                    <!-- Delete Patient Modal -->
                                    @include('admin.patients.delete_modal', ['patient' => $patient])
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
                        <li class="page-item {{ $patients->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $patients->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $patients->lastPage(); $i++)
                            <li class="page-item {{ $i == $patients->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $patients->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $patients->currentPage() == $patients->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $patients->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Create Patient Modal -->
    @include('admin.patients.create_modal')
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<!-- Include Bootstrap CSS for pagination styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
