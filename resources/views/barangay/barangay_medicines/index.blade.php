@extends('layouts.app')

@section('title', 'Medicine Inventory - Barangay Medicines')

@section('content')
    <div class="container-fluid">
        <div class="mb-8 d-sm-flex justify-content-between align-items-center">
            <h1 class="mb-3 mb-sm-0">Barangay Medicines</h1>
            <div class="d-flex flex-column flex-sm-row">
                @if (auth()->user()->isBHW())
                    <button type="button" class="btn btn-success mb-2 mb-sm-0" data-toggle="modal"
                        data-target="#generateBarangayMedicineReportModal">
                        <i class="fas fa-file-export"></i> Report
                    </button>
                @endif
            </div>
        </div>
        <div class="modal fade" id="generateBarangayMedicineReportModal" tabindex="-1" role="dialog"
            aria-labelledby="generateBarangayMedicineReportModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="generateBarangayMedicineReportModalLabel">Generate Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('barangay-medicines.generateBarangayMedicineReport') }}" method="post">
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
            <div class="alert alert-success position-fixed bottom-0 end-0 mb-3 mr-3" style="z-index: 9999;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        {{ session('success') }}
                    </div>
                    <i class="fas fa-solid fa-xmark" style="cursor: pointer; margin-left: 10px;" data-bs-dismiss="alert"
                        aria-label="Close"></i>
                </div>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger position-fixed bottom-0 end-0 mb-3 mr-3" style="z-index: 9999;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        {{ session('error') }}
                    </div>
                    <i class="fas fa-solid fa-xmark" style="cursor: pointer; margin-left: 10px;" data-bs-dismiss="alert"
                        aria-label="Close"></i>
                </div>
            </div>
        @endif

        <div class="breadcrumb" style="margin-top: 10px">
            <h6><a href="{{ route('home') }}">Dashboard</a> / Barangay Medicines</h6>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end align-items-center">
                    <form action="{{ route('barangay-medicines.index') }}" method="GET" class="form-inline">
                        <div class="form-group mr-2">
                            <label for="entriesSelect" class="mr-2 d-none d-md-inline">Show:</label>
                            <select id="entriesSelect" class="form-control" name="entries">
                                <option value="10" {{ $entries == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $entries == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $entries == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $entries == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="form-group flex-grow-1">
                            <input type="text" class="form-control" placeholder="Search" name="search"
                                value="{{ $query }}">
                        </div>
                        <div class="form-group ml-2">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <!-- Medicine Table -->
                <div class="table-responsive">
                    @if ($barangayMedicines->isEmpty())
                        <p>No medicines found for your barangay.</p>
                    @else
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th onclick="handleSort('id')">ID</th>
                                    @if (auth()->user()->isAdmin())
                                        <th onclick="handleSort('barangay_id')">Barangay</th>
                                    @endif
                                    <th onclick="handleSort('generic_name')">Generic Name</th>
                                    <th onclick="handleSort('brand_name')">Brand Name</th>
                                    <th onclick="handleSort('category')">Category</th>
                                    <th onclick="handleSort('stocks')">Stocks</th>
                                    @if (auth()->user()->isBHW())
                                        <th onclick="handleSort('created_at')">Added At</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangayMedicines as $barangayMedicine)
                                    <tr>
                                        <td>{{ $barangayMedicine->id }}</td>
                                        @if (auth()->user()->isAdmin())
                                            <td>{{ $barangayMedicine->barangay->name }}</td>
                                        @endif
                                        <td>{{ $barangayMedicine->generic_name }}</td>
                                        <td>{{ $barangayMedicine->brand_name }}</td>
                                        <td>{{ $barangayMedicine->medicine->category->name }}</td>
                                        <td>{{ $barangayMedicine->stocks }}</td>
                                        @if (auth()->user()->isBHW())
                                            <td>{{ $barangayMedicine->created_at }}</td>
                                        @endif
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Medicine Actions">
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#showbarangayMedicineModal{{ $barangayMedicine->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('barangay.barangay_medicines.show_modal', [
                                        'barangayMedicines' => $barangayMedicine,
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
                Showing {{ $barangayMedicines->firstItem() }} to {{ $barangayMedicines->lastItem() }} of
                {{ $barangayMedicines->total() }}
                entries
            </div>
            <div class="float-right">
                <!-- Bootstrap Pagination -->
                <ul class="pagination">
                    <li class="page-item {{ $barangayMedicines->currentPage() == 1 ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ $barangayMedicines->previousPageUrl() }}&entries={{ $entries }}"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @php
                        $currentPage = $barangayMedicines->currentPage();
                        $lastPage = $barangayMedicines->lastPage();
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
                            <a class="page-link"
                                href="{{ $barangayMedicines->url(1) }}&entries={{ $entries }}">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $barangayMedicines->url($i) }}&entries={{ $entries }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($showLastDots)
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $barangayMedicines->url($lastPage) }}&entries={{ $entries }}">{{ $lastPage }}</a>
                        </li>
                    @endif

                    <li class="page-item {{ $barangayMedicines->currentPage() == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $barangayMedicines->nextPageUrl() }}&entries={{ $entries }}"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    </div>

    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Include Bootstrap CSS for pagination styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrap.com/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
                    url: "{{ route('barangay-medicines.index') }}",
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
            window.location = "{{ route('barangay-medicines.index') }}?column=" + column + "&order=" + order +
                "&entries=" +
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

        body.dark-mode #generateBarangayMedicineReportModal .modal-content {
            background-color: #343a40;
            color: #fff;
        }

        body.dark-mode #generateBarangayMedicineReportModal .modal-header {
            background-color: #343a40;
            color: #fff;
            border-bottom: 1px solid #007bff;
        }

        body.dark-mode #generateBarangayMedicineReportModal .modal-title {
            color: #fff;
        }

        body.dark-mode #generateBarangayMedicineReportModal .modal-body {
            background-color: #343a40;
            color: #fff;
        }

        body.dark-mode #generateBarangayMedicineReportModal label,
        body.dark-mode #generateBarangayMedicineReportModal .form-control {
            color: #fff;
        }

        body.dark-mode #generateBarangayMedicineReportModal .form-control {
            background-color: #2d2d2d;
            /* Dark mode background color for input elements */
            border: 1px solid #6c757d;
            /* White border for input elements */
            color: #fff;
        }

        body.dark-mode #generateBarangayMedicineReportModal .modal-footer {
            background-color: #343a40;
            border-top: 1px solid #007bff;
        }

        body.dark-mode #generateBarangayMedicineReportModal .btn-secondary {
            color: #fff;
        }
    </style>
@endsection
