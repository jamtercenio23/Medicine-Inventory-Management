@extends('layouts.app')

@section('title', 'Medicine Inventory - Out of Stock Medicines')

@section('content')
    <div class="container-fluid">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Out of Stock Medicines</h1>
            <div class="d-flex">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#generateOutOfStockReportModal">
                    <i class="fas fa-file-export"></i> Report
                </button>
            </div>
        </div>

        <!-- Generate Out of Stock Report Modal -->
        <div class="modal fade" id="generateOutOfStockReportModal" tabindex="-1" role="dialog"
            aria-labelledby="generateOutOfStockReportModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="generateOutOfStockReportModalLabel">Generate Out of Stock Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Add your form elements for selecting date range and export format here -->
                        <form action="{{ route('medicines.generateOutOfStockReport') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="from">From Date</label>
                                <input type="date" class="form-control" id="from" name="from" required>
                            </div>
                            <div class="form-group">
                                <label for="to">To Date</label>
                                <input type="date" class="form-control" id="to" name="to" required>
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
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="breadcrumb">
            <h6><a href="{{ route('home') }}">Dashboard</a> / <a href="{{ route('medicines.index') }}">Medicines</a> / Out of Stock Medicines</h6>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('medicines.out-of-stock') }}" method="GET" class="form-inline">
                        <div class="input-group mr-2">
                            <label for="entriesSelect" class="mr-2">Show:</label>
                            <select id="entriesSelect" class="form-control" name="entries">
                                <option value="10" {{ $entries == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $entries == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $entries == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $entries == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
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
                    @if ($outOfStockMedicines->isEmpty())
                        <p>No out-of-stock medicines found.</p>
                    @else
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th onclick="handleSort('id')">ID</th>
                                    <th onclick="handleSort('generic_name')">Generic Name</th>
                                    <th onclick="handleSort('brand_name')">Brand Name</th>
                                    <th onclick="handleSort('category_id')">Category</th>
                                    <th onclick="handleSort('price')">Price</th>
                                    <th onclick="handleSort('expiration_date')">Expiration Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outOfStockMedicines as $medicine)
                                    <tr>
                                        <td>{{ $medicine->id }}</td>
                                        <td>{{ $medicine->generic_name }}</td>
                                        <td>{{ $medicine->brand_name }}</td>
                                        <td>{{ $medicine->category->name }}</td>
                                        <td>₱ {{ $medicine->price }}</td>
                                        <td>{{ $medicine->expiration_date }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editOutOfStockModal{{ $medicine->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Edit Out of Stock Medicine Modal -->
                                    @include('admin.medicines.edit_out_of_stock_modal', [
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
            <div class="float-left">
                Showing {{ $outOfStockMedicines->firstItem() }} to {{ $outOfStockMedicines->lastItem() }} of {{ $outOfStockMedicines->total() }}
                entries
            </div>
            <div class="float-right">
                <!-- Bootstrap Pagination -->
                <ul class="pagination">
                    <li class="page-item {{ $outOfStockMedicines->currentPage() == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $outOfStockMedicines->previousPageUrl() }}&entries={{ $entries }}"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @php
                        $currentPage = $outOfStockMedicines->currentPage();
                        $lastPage = $outOfStockMedicines->lastPage();
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
                            <a class="page-link" href="{{ $outOfStockMedicines->url(1) }}&entries={{ $entries }}">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $outOfStockMedicines->url($i) }}&entries={{ $entries }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($showLastDots)
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $outOfStockMedicines->url($lastPage) }}&entries={{ $entries }}">{{ $lastPage }}</a>
                        </li>
                    @endif

                    <li class="page-item {{ $outOfStockMedicines->currentPage() == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $outOfStockMedicines->nextPageUrl() }}&entries={{ $entries }}"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrap.com/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#entriesSelect').change(function() {
                updateTable();
            });

            $('#searchInput').on('input', function() {
                delay(function() {
                    updateTable();
                }, 500);
            });

            function updateTable() {
                var entries = $('#entriesSelect').val();
                var searchQuery = $('#searchInput').val();

                $.ajax({
                    url: "{{ route('medicines.out-of-stock') }}",
                    type: 'GET',
                    data: {
                        entries: entries,
                        search: searchQuery,
                        column: "{{ $column }}", // Include the current column for sorting
                        order: "{{ $order }}" // Include the current order for sorting
                    },
                    success: function(data) {
                        $('#categoryTable').html(data);
                    },
                    error: function() {
                        console.log('Error occurred while updating table.');
                    }
                });
            }

            // Initial update on page load
            updateTable();
        });

        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        });

        function handleSort(column) {
            var order = 'asc';

            if (column === "{{ $column }}") {
                order = "{{ $order === 'asc' ? 'desc' : 'asc' }}";
            }

            var entries = $('#entriesSelect').val(); // Get the selected number of entries
            window.location = "{{ route('medicines.out-of-stock') }}?column=" + column + "&order=" + order + "&entries=" +
                entries;
        }
    </script>
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

        body.dark-mode #generateOutOfStockReportModal .modal-content {
            background-color: #343a40;
            color: #fff;
        }

        body.dark-mode #generateOutOfStockReportModal .modal-header {
            background-color: #343a40;
            color: #fff;
            border-bottom: 1px solid #007bff;
        }

        body.dark-mode #generateOutOfStockReportModal .modal-title {
            color: #fff;
        }

        body.dark-mode #generateOutOfStockReportModal .modal-body {
            background-color: #343a40;
            color: #fff;
        }

        body.dark-mode #generateOutOfStockReportModal label,
        body.dark-mode #generateOutOfStockReportModal .form-control {
            color: #fff;
        }

        body.dark-mode #generateOutOfStockReportModal .form-control {
            background-color: #2d2d2d;
            /* Dark mode background color for input elements */
            border: 1px solid #6c757d;
            /* White border for input elements */
            color: #fff;
        }

        body.dark-mode #generateOutOfStockReportModal .modal-footer {
            background-color: #343a40;
            border-top: 1px solid #007bff;
        }

        body.dark-mode #generateOutOfStockReportModal .btn-secondary {
            color: #fff;
        }
    </style>
@endsection
