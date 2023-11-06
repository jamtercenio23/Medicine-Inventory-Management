@extends('layouts.app')

@section('title', 'Medicine Inventory - Barangay Distributions')

@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Barangay Distribution</h1>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createDistributionModal">
                <i class="fas fa-plus"></i> Add Distribution
            </button>
        </div>

        <!-- Display alert message if present -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h5><a href="{{ route('home') }}">Dashboard</a> / Distributions</h5>

        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('barangay-distributions.index') }}" method="GET" class="form-inline">
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
                <!-- Display message when there are no distributions -->
                @if ($barangayDistributions->isEmpty())
                    <p>No distributions found.</p>
                @else
                    <!-- Distribution Table -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangayDistributions as $barangayDistribution)
                                <tr>
                                    <td>{{ $barangayDistribution->id }}</td>
                                    <td>{{ $barangayDistribution->patient->first_name }} {{ $barangayDistribution->patient->last_name }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#showDistributionModal{{ $barangayDistribution->id }}">
                                            <i class="fas fa-eye"></i> Show</button>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editDistributionModal{{ $barangayDistribution->id }}">
                                            <i class="fas fa-edit"></i> Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteDistributionModal{{ $barangayDistribution->id }}">
                                            <i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>

                                <!-- Show Distribution Modal -->
                                @include('barangay.barangay_distributions.show_modal', [
                                    'barangayDistribution' => $barangayDistribution,
                                ])

                                <!-- Edit Distribution Modal -->
                                @include('barangay.barangay_distributions.edit_modal', [
                                    'barangayDistribution' => $barangayDistribution,
                                ])

                                <!-- Delete Distribution Modal -->
                                @include('barangay.barangay_distributions.delete_modal', [
                                    'barangayDistribution' => $barangayDistribution,
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
                        <li class="page-item {{ $barangayDistributions->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $barangayDistributions->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $barangayDistributions->lastPage(); $i++)
                            <li class="page-item {{ $i == $barangayDistributions->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $barangayDistributions->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li
                            class="page-item {{ $barangayDistributions->currentPage() == $barangayDistributions->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $barangayDistributions->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @include('barangay.barangay_distributions.create_modal')
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
