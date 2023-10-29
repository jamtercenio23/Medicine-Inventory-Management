@extends('layouts.app')

@section('title', 'User Management - Users')

@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>User Management</h1>
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
            <h4><a href="{{ route('home') }}">Dashboard</a> / Users</h4>
        </div>
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createUserModal">
            Add User
        </button>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('users.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search"
                                value="{{ $query }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-sm" type="submit">Search</button>
                            </div>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
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
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editUserModal{{ $user->id }}">Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteUserModal{{ $user->id }}">Delete</button>
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
            <div class="card-footer text-muted">
                <div class="float-left">
                    <!-- You can add any additional content here if needed -->
                </div>
                <div class="float-right">
                    <!-- Bootstrap Pagination -->
                    <ul class="pagination">
                        <li class="page-item {{ $users->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li
                            class="page-item {{ $users->currentPage() == $users->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @endsection
