@extends('layouts.app')
@section('title', 'Medicine Inventory - Distribution to Barangays')
@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Distribution to Barangays</h1>
        </div>

        <!-- Display alert message if present -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h4><a href="{{ route('home') }}">Dashboard</a> / Distribution to Barangays</h4>
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createDistributionBarangayModal">
            Add Distribution
        </button>

        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('distribution_barangay.index') }}" method="GET" class="form-inline">
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
                <!-- Display message when there are no distributions -->
                @if ($distribution_barangays->isEmpty())
                    <p>No distributions to barangays found.</p>
                @else
                    <!-- Distribution to Barangay Table -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Barangay</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($distribution_barangays as $distribution_barangay)
                                <tr>
                                    <td>{{ $distribution_barangay->id }}</td>
                                    <td>{{ $distribution_barangay->barangay->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#showDistributionBarangayModal{{ $distribution_barangay->id }}">
                                            <i class="fas fa-eye"></i> Show</button>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editDistributionBarangayModal{{ $distribution_barangay->id }}">
                                            <i class="fas fa-edit"></i> Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteDistributionBarangayModal{{ $distribution_barangay->id }}">
                                            <i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>

                                <!-- Show Distribution to Barangay Modal -->
                                @include('admin.distribution_barangay.show_modal', [
                                    'distribution' => $distribution_barangay,
                                ])

                                <!-- Edit Distribution to Barangay Modal -->
                                @include('admin.distribution_barangay.edit_modal', [
                                    'distribution' => $distribution_barangay,
                                ])

                                <!-- Delete Distribution to Barangay Modal -->
                                @include('admin.distribution_barangay.delete_modal', [
                                    'distribution' => $distribution_barangay,
                                ])
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
                        <li class="page-item {{ $distribution_barangays->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $distribution_barangays->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $distribution_barangays->lastPage(); $i++)
                            <li class="page-item {{ $i == $distribution_barangays->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $distribution_barangays->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li
                            class="page-item {{ $distribution_barangays->currentPage() == $distribution_barangays->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $distribution_barangays->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Create Distribution to Barangay Modal -->
    @include('admin.distribution_barangay.create_modal')
@endsection

<!-- Include Bootstrap CSS for pagination styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
