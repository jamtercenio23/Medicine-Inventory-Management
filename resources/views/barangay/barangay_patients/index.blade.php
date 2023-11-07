@extends('layouts.app')

@section('title', 'Medicine Inventory - Barangay Patients')

@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Barangay Patients</h1>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createBarangayPatientModal">
                <i class="fas fa-plus"></i> Add Patient
            </button>
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
        <h5><a href="{{ route('home') }}">Dashboard</a> / Barangay Patients</h5>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('barangay-patients.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search"
                                value="{{ $query }}">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
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
                    @if ($barangayPatients->isEmpty())
                        <p>No patients found.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Barangay</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangayPatients as $barangayPatient)
                                    <tr>
                                        <td>{{ $barangayPatient->id }}</td>
                                        <td>{{ $barangayPatient->barangay->name }}</td>
                                        <td>{{ $barangayPatient->first_name }} {{ $barangayPatient->last_name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#showBarangayPatientModal{{ $barangayPatient->id }}">
                                                <i class="fas fa-eye"></i> Show
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editBarangayPatientModal{{ $barangayPatient->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteBarangayPatientModal{{ $barangayPatient->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Show Patient Modal -->
                                    @include('barangay.barangay_patients.show_modal', ['barangayPatient' => $barangayPatient])

                                    <!-- Edit Patient Modal -->
                                    @include('barangay.barangay_patients.edit_modal', ['barangayPatient' => $barangayPatient])

                                    <!-- Delete Patient Modal -->
                                    @include('barangay.barangay_patients.delete_modal', ['barangayPatient' => $barangayPatient])
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
                        <li class="page-item {{ $barangayPatients->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $barangayPatients->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $barangayPatients->lastPage(); $i++)
                            <li class="page-item {{ $i == $barangayPatients->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $barangayPatients->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $barangayPatients->currentPage() == $barangayPatients->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $barangayPatients->nextPageUrl() }}" aria-label="Next">
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
    @include('barangay.barangay_patients.create_modal')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Include Bootstrap CSS for pagination styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
        }
    </style>
@endsection
