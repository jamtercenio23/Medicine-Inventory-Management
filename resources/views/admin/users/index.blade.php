@extends('layouts.app')

@section('title', 'Medicine Inventory - User Management')

@section('content')
    <div class="container-fluid">
        <div class="mb-8 d-sm-flex justify-content-between align-items-center">
            <h1 class="mb-3 mb-sm-0">User Management</h1>
            <div class="d-flex flex-column flex-sm-row">
                <button type="button" class="btn btn-primary mb-2 mb-sm-0" data-toggle="modal" data-target="#createUserModal">
                    <i class="fa-solid fa-user-plus"></i> Add User
                </button>
            </div>
        </div>

        <div>
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
                <h6><a href="{{ route('home') }}">Dashboard</a> / Users</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end align-items-center">
                    <form action="{{ route('users.index') }}" method="GET" class="form-inline">
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
                            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $query }}">
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
                <!-- User Table -->
                <div class="table-responsive">
                    @if ($users->isEmpty())
                        <p>No users found.</p>
                    @else
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th onclick="handleSort('id')">ID</th>
                                    <th onclick="handleSort('name')">Name</th>
                                    <th onclick="handleSort('email')">Email</th>
                                    <th>Role</th>
                                    <th onclick="handleSort('is_active')">Status</th>
                                    <th onclick="handleSort('created_at')">Created At</th>
                                    <th onclick="handleSort('updated_at')">Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->roles->isNotEmpty())
                                                {{ $user->roles->first()->name }}
                                            @else
                                                No Role
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->updated_at }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="User Actions">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#editUserModal{{ $user->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteUserModal{{ $user->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit User Modal -->
                                    @include('admin.users.edit_modal', ['user' => $user])

                                    <!-- Delete User Modal -->
                                    @include('admin.users.delete_modal', ['user' => $user])
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="my-4 text-muted">
            <div class="float-left">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}
                entries
            </div>
            <div class="float-right">
                <!-- Bootstrap Pagination -->
                <ul class="pagination">
                    <li class="page-item {{ $users->currentPage() == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}&entries={{ $entries }}"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @php
                        $currentPage = $users->currentPage();
                        $lastPage = $users->lastPage();
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
                            <a class="page-link" href="{{ $users->url(1) }}&entries={{ $entries }}">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $users->url($i) }}&entries={{ $entries }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($showLastDots)
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $users->url($lastPage) }}&entries={{ $entries }}">{{ $lastPage }}</a>
                        </li>
                    @endif

                    <li class="page-item {{ $users->currentPage() == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}&entries={{ $entries }}"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- Create User Modal -->
    @include('admin.users.create_modal')
    </div>

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
                    url: "{{ route('users.index') }}",
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
            window.location = "{{ route('users.index') }}?column=" + column + "&order=" + order + "&entries=" +
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
    </style>
@endsection
