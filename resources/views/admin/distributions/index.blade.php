@extends('layouts.app')

@section('title', 'Medicine Inventory - Distributions')

@section('content')
    <div class="container-fluid">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Patient Distribution</h1>
            <div class="d-flex">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createDistributionModal">
                    <i class="fas fa-plus"></i> Add Distribution
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal"
                    data-target="#generateDistributionReportModal">
                    <i class="fas fa-file-export"></i> Report
                </button>
            </div>
        </div>
        <div class="modal fade" id="generateDistributionReportModal" tabindex="-1" role="dialog"
            aria-labelledby="generateDistributionReportModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="generateDistributionReportModalLabel">Generate Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('distributions.generateDistributionReport') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="fromDate">From Date:</label>
                                <input type="date" class="form-control" id="fromDate" name="from" required>
                            </div>
                            <div class="form-group">
                                <label for="toDate">To Date:</label>
                                <input type="date" class="form-control" id="toDate" name="to" required>
                            </div>
                            <div class="form-group">
                                <label for="exportFormat">Export Format</label>
                                <select class="form-control" id="exportFormat" name="exportFormat" required>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Generate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
            <h5><a href="{{ route('home') }}">Dashboard</a> / Distribution for Patients</h5>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('distributions.index') }}" method="GET" class="form-inline">
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
                @if ($distributions->isEmpty())
                    <p>No distributions found.</p>
                @else
                    <!-- Distribution Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    <th>Checkup Date</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distributions as $distribution)
                                    <tr>
                                        <td>{{ $distribution->id }}</td>
                                        <td>{{ $distribution->patient->first_name }} {{ $distribution->patient->last_name }}
                                        </td>
                                        <td>{{ $distribution->checkup_date }}</td>
                                        <td>{{ $distribution->created_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#showDistributionModal{{ $distribution->id }}">
                                                <i class="fas fa-eye"></i> </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editDistributionModal{{ $distribution->id }}">
                                                <i class="fas fa-edit"></i> </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteDistributionModal{{ $distribution->id }}">
                                                <i class="fas fa-trash"></i> </button>
                                        </td>
                                    </tr>

                                    <!-- Show Distribution Modal -->
                                    @include('admin.distributions.show_modal', [
                                        'distribution' => $distribution,
                                    ])

                                    <!-- Edit Distribution Modal -->
                                    @include('admin.distributions.edit_modal', [
                                        'distribution' => $distribution,
                                    ])

                                    <!-- Delete Distribution Modal -->
                                    @include('admin.distributions.delete_modal', [
                                        'distribution' => $distribution,
                                    ])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="my-4 text-muted">
            <div class="float-left">
                <div class="credits">
                    <p>Mabini Health Center</p>
                </div>
            </div>
            <div class="float-right">
                <!-- Bootstrap Pagination -->
                <ul class="pagination">
                    <li class="page-item {{ $distributions->currentPage() == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $distributions->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @php
                        $currentPage = $distributions->currentPage();
                        $lastPage = $distributions->lastPage();
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
                            <a class="page-link" href="{{ $distributions->url(1) }}">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="{{ $distributions->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($showLastDots)
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $distributions->url($lastPage) }}">{{ $lastPage }}</a>
                        </li>
                    @endif

                    <li class="page-item {{ $distributions->currentPage() == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $distributions->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    @include('admin.distributions.create_modal')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrap.com/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-bottom: 20px;
        }

        .breadcrumb {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #000;
            /* Breadcrumb text color */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table th {
            background-color: #343a40;
            color: #fff;
            padding: 8px;
        }

        .table th,
        .table td {
            padding: 6px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .pagination {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .pagination li {
            display: inline;
            margin-right: 5px;
        }

        .pagination a {
            text-decoration: none;
            border: 1px solid #007bff;
            color: #007bff;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .btn {
            margin-right: 5px;
        }

        .form-control {
            border-radius: 5px;
        }

        .alert-success {
            background-color: #28a745;
            color: #fff;
        }

        .alert-danger {
            background-color: #dc3545;
            color: #fff;
        }

        /* Dark mode styles */
        body.dark-mode .card {
            background-color: #343a40;
            color: #fff;
        }

        body.dark-mode .breadcrumb {
            background-color: #1e1e1e;
            color: #fff;
        }

        body.dark-mode .table {
            background-color: #2d2d2d;
            color: #fff;
        }

        body.dark-mode .table th {
            background-color: #1e1e1e;
            color: #fff;
        }

        body.dark-mode .table th,
        body.dark-mode .table td {
            border: 1px solid #333;
            background-color: #2d2d2d;
            /* Darker background for cells */
            color: #fff;
        }

        body.dark-mode .pagination a {
            text-decoration: none;
            color: #007bff;
            background-color: #343a40;
            /* Dark mode background color for pagination links */
        }

        body.dark-mode .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

        body.dark-mode .pagination .page-item:first-child .page-link,
        body.dark-mode .pagination .page-item:last-child .page-link {
            border: 1px solid #007bff;
            color: #007bff;
            background-color: #343a40;
        }

        body.dark-mode .pagination .page-item:first-child .page-link:hover,
        body.dark-mode .pagination .page-item:last-child .page-link:hover {
            background-color: #007bff;
            color: #fff;
        }

        body.dark-mode .pagination .page-item.disabled .page-link {
            background-color: #343a40;
            color: #6c757d;
            border: 1px solid #343a40;
        }

        body.dark-mode .form-control {
            background-color: #2d2d2d;
            color: #fff;
        }

        body.dark-mode #generateDistributionReportModal .modal-content {
            background-color: #343a40;
            color: #fff;
        }

        body.dark-mode #generateDistributionReportModal .modal-header {
            background-color: #343a40;
            color: #fff;
            border-bottom: 1px solid #007bff;
        }

        body.dark-mode #generateDistributionReportModal .modal-title {
            color: #fff;
        }

        body.dark-mode #generateDistributionReportModal .modal-body {
            background-color: #343a40;
            color: #fff;
        }

        body.dark-mode #generateDistributionReportModal label,
        body.dark-mode #generateDistributionReportModal .form-control {
            color: #fff;
        }

        body.dark-mode #generateDistributionReportModal .form-control {
            background-color: #2d2d2d;
            /* Dark mode background color for input elements */
            border: 1px solid #6c757d;
            /* White border for input elements */
            color: #fff;
        }

        body.dark-mode #generateDistributionReportModal .modal-footer {
            background-color: #343a40;
            border-top: 1px solid #007bff;
        }

        body.dark-mode #generateDistributionReportModal .btn-secondary {
            color: #fff;
        }
    </style>
@endsection
