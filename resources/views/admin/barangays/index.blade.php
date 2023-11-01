@extends('layouts.app')
@section('title', 'Medicine Inventory - Barangays')
@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Barangays</h1>
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
        <h4><a href="{{ route('home') }}">Dashboard</a> / Barangay</h4>
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createBarangayModal">
            Add Barangay
        </button>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('barangays.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search"
                                value="{{ $query }}">
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
                <!-- Display message when there are no barangays -->
                @if ($barangays->isEmpty())
                    <p>No barangays found.</p>
                @else
                    <!-- Barangay Table -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangays as $barangay)
                                <tr>
                                    <td>{{ $barangay->id }}</td>
                                    <td>{{ $barangay->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#showBarangayModal{{ $barangay->id }}">
                                            <i class="fas fa-eye"></i> Show</button>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editBarangayModal{{ $barangay->id }}">
                                            <i class="fas fa-edit"></i> Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteBarangayModal{{ $barangay->id }}">
                                            <i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>
                                @include('admin.barangays.show_modal', ['barangay' => $barangay])
                                <!-- Edit Barangay Modal -->
                                @include('admin.barangays.edit_modal', ['barangay' => $barangay])

                                <!-- Delete Barangay Modal -->
                                @include('admin.barangays.delete_modal', ['barangay' => $barangay])
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="card-footer text-muted">
                <div class="float-left">
                    <!-- You can add any additional content here if needed -->
                </div>
                <div class="float-right">
                    <!-- Bootstrap Pagination -->
                    <ul class="pagination">
                        <li class="page-item {{ $barangays->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $barangays->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $barangays->lastPage(); $i++)
                            <li class="page-item {{ $i == $barangays->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $barangays->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $barangays->currentPage() == $barangays->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $barangays->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Create Barangay Modal -->
    @include('admin.barangays.create_modal')
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<!-- Include Bootstrap CSS for pagination styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
