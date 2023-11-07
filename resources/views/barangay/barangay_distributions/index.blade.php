@extends('layouts.app')

@section('title', 'Medicine Inventory - Barangay Distributions')

@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Manage Distributions</h1>
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

        <div class="breadcrumb">
            <h5><a href="{{ route('home') }}">Dashboard</a> / Barangay Distributions</h5>
        </div>

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
                <!-- Distribution Table -->
                <div class="table-responsive">
                    @if ($barangayDistributions->isEmpty())
                        <p>No distributions found.</p>
                    @else
                    <table class="table table-hover table-sm">
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
                                        <td>{{ $barangayDistribution->patient->first_name }}
                                            {{ $barangayDistribution->patient->last_name }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#showDistributionModal{{ $barangayDistribution->id }}">
                                                <i class="fas fa-eye"></i> Show
                                            </button>
                                            <button type of="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editDistributionModal{{ $barangayDistribution->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteDistributionModal{{ $barangayDistribution->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
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
            </div>
        </div>
        <div class="my-4 text-muted">
            <div class="float-left"></div>
            <div class="float-right">
                <!-- Bootstrap Pagination -->
                <ul class="pagination">
                    <li class="page-item {{ $barangayDistributions->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $barangayDistributions->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @php
                        $currentPage = $barangayDistributions->currentPage();
                        $lastPage = $barangayDistributions->lastPage();
                        $showFirstDots = false;
                        $showLastDots = false;

                        // Determine the range of page numbers to display
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($lastPage, $currentPage + 2);

                        if ($startPage > 1) {
                            $showFirstDots = true;
                            $startPage++;
                        }

                        if ($endPage < $lastPage) {
                            $showLastDots = true;
                            $endPage--;
                        }
                    @endphp

                    @if ($showFirstDots)
                        <li class="page-item">
                            <a class="page-link" href="{{ $barangayDistributions->url(1) }}">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="{{ $barangayDistributions->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($showLastDots)
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $barangayDistributions->url($lastPage) }}">{{ $lastPage }}</a>
                        </li>
                    @endif

                    <li class="page-item {{ $barangayDistributions->currentPage() == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $barangayDistributions->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    @include('barangay.barangay_distributions.create_modal')
    <!-- Create Patient Modal -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrap.com/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
        }
    </style>
@endsection
