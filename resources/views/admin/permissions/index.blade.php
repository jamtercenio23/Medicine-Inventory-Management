@extends('layouts.app')

@section('title', 'Medicine Inventory - Permissions')

@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Permissions</h1>
        </div>

        <div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <h4><a href="{{ route('home') }}">Dashboard</a> / Permissions</h4>
        </div>

        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createPermissionModal">
            Add Permission
        </button>

        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('permissions.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $query }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-sm" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <!-- Permission Table -->
                <div class="table-responsive">
                    @if ($permissions->isEmpty())
                        <p>No permissions found.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editPermissionModal{{ $permission->id }}">Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deletePermissionModal{{ $permission->id }}">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Edit Permission Modal -->
                                    @include('admin.permissions.edit_modal', ['permission' => $permission])

                                    <!-- Delete Permission Modal -->
                                    @include('admin.permissions.delete_modal', ['permission' => $permission])
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="float-left">
                    <!-- You can add any additional content here if needed -->
                </div>
                <div class="float-right">
                    <!-- Bootstrap Pagination -->
                    <ul class="pagination">
                        <li class="page-item {{ $permissions->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $permissions->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $permissions->lastPage(); $i++)
                            <li class="page-item {{ $i == $permissions->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $permissions->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $permissions->currentPage() == $permissions->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $permissions->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Create Permission Modal -->
    @include('admin.permissions.create_modal')
</div>

<!-- Include Bootstrap CSS for pagination styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
