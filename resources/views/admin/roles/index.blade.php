@extends('layouts.app')
@section('title', 'Medicine Inventory - Roles')
@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Role Management</h1>
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
            <h4><a href="{{ route('home') }}">Dashboard</a> / Roles</h4>
        </div>
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createRoleModal">
            Add Role
        </button>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('roles.index') }}" method="GET" class="form-inline">
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
                <!-- Role Table -->
                <div class="table-responsive">
                    @if ($roles->isEmpty())
                        <p>No roles found.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Role Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#showRoleModal{{ $role->id }}">Show</button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editRoleModal{{ $role->id }}">Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteRoleModal{{ $role->id }}">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Show Role Modal -->
                                    @include('admin.roles.show_modal', ['role' => $role])

                                    <!-- Edit Role Modal -->
                                    @include('admin.roles.edit_modal', ['role' => $role])

                                    <!-- Delete Role Modal -->
                                    @include('admin.roles.delete_modal', ['role' => $role])
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="float-left">
                </div>
                <div class="float-right">
                    {{ $roles->links() }}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Create Role Modal -->
    @include('admin.roles.create_modal')
</div>
@endsection
