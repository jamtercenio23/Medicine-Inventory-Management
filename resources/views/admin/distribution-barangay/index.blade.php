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
                    <form action="{{ route('distribution-barangay.index') }}" method="GET" class="form-inline">
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
                @if ($distributions->isEmpty())
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
                            @foreach ($distributions as $distribution)
                                <tr>
                                    <td>{{ $distribution->id }}</td>
                                    <td>{{ $distribution->barangay->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#showDistributionBarangayModal{{ $distribution->id }}">
                                            <i class="fas fa-eye"></i> Show</button>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editDistributionBarangayModal{{ $distribution->id }}">
                                            <i class="fas fa-edit"></i> Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteDistributionBarangayModal{{ $distribution->id }}">
                                            <i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>

                                <!-- Show Distribution to Barangay Modal -->
                                @include('admin.distribution-barangay.show_modal', [
                                    'distribution' => $distribution,
                                ])

                                <!-- Edit Distribution to Barangay Modal -->
                                @include('admin.distribution-barangay.edit_modal', [
                                    'distribution' => $distribution,
                                ])

                                <!-- Delete Distribution to Barangay Modal -->
                                @include('admin.distribution-barangay.delete_modal', [
                                    'distribution' => $distribution,
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
                        <li class="page-item {{ $distributions->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $distributions->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $distributions->lastPage(); $i++)
                            <li class="page-item {{ $i == $distributions->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $distributions->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li
                            class="page-item {{ $distributions->currentPage() == $distributions->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $distributions->nextPageUrl() }}" aria-label="Next">
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
    @include('admin.distribution-barangay.create_modal')
@endsection

<!-- Include Bootstrap CSS for pagination styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
