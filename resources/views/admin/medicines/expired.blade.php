@extends('layouts.app')

@section('title', 'Medicine Inventory - Expired Medicines')

@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Expired Medicines</h1>
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
        <div class="breadcrumb">
            <h5><a href="{{ route('home') }}">Dashboard</a> / Expired Medicines</h5>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('medicines.expired') }}" method="GET" class="form-inline">
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
                <!-- Medicine Table -->
                <div class="table-responsive">
                    @if ($expiredMedicines->isEmpty())
                        <p>No expired medicines found.</p>
                    @else
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Medicine Name</th>
                                    <th>Expiration Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expiredMedicines as $medicine)
                                    <tr>
                                        <td>{{ $medicine->id }}</td>
                                        <td>{{ $medicine->generic_name }} - {{ $medicine->brand_name }}</td>
                                        <td>{{ $medicine->expiration_date }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteExpiredModal{{ $medicine->id }}"><i
                                                    class="fas fa-trash"></i> Delete</button>
                                        </td>
                                    </tr>
                                    <!-- Delete Expired Medicine Modal -->
                                    @include('admin.medicines.delete_expired_modal', [
                                        'medicine' => $medicine,
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
                    <li class="page-item {{ $expiredMedicines->currentPage() == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $expiredMedicines->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @php
                        $currentPage = $expiredMedicines->currentPage();
                        $lastPage = $expiredMedicines->lastPage();
                        $showFirstDots = false;
                        $showLastDots = false;

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
                            <a class="page-link" href="{{ $expiredMedicines->url(1) }}">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="{{ $expiredMedicines->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($showLastDots)
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $expiredMedicines->url($lastPage) }}">{{ $lastPage }}</a>
                        </li>
                    @endif

                    <li class="page-item {{ $expiredMedicines->currentPage() == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $expiredMedicines->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- Include Bootstrap CSS for pagination styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrap.com/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            /* Smaller font size */
        }

        .table th {
            background-color: #343a40;
            color: #fff;
            padding: 8px;
            /* Reduced padding */
        }

        .table th,
        .table td {
            padding: 6px;
            /* Reduced padding */
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

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #218838;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-secondary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert-success {
            background-color: #28a745;
            color: #fff;
        }

        .alert-danger {
            background-color: #dc3545;
            color: #fff;
        }

        /* Style the breadcrumb */
        .breadcrumb {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
@endsection
