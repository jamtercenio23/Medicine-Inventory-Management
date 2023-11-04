@extends('layouts.app')

@section('title', 'Medicine Inventory - Categories')

@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Medicine Categories</h1>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createCategoryModal">
                <i class="fas fa-plus"></i> Add Category
            </button>
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
        <h5><a href="{{ route('home') }}">Dashboard</a> / Categories</h5>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('categories.index') }}" method="GET" class="form-inline">
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
                <!-- Display message when there are no categories -->
                @if ($categories->isEmpty())
                    <p>No categories found.</p>
                @else
                    <!-- Category Table -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editCategoryModal{{ $category->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteCategoryModal{{ $category->id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                @include('admin.categories.edit_modal', ['category' => $category])
                                @include('admin.categories.delete_modal', ['category' => $category])
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="card-footer text-muted">
                <div class="float-left">
                </div>
                <div class="float-right">
                    <ul class="pagination">
                        <li class="page-item {{ $categories->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $categories->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $categories->lastPage(); $i++)
                            <li class="page-item {{ $i == $categories->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $categories->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li
                            class="page-item {{ $categories->currentPage() == $categories->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $categories->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    @include('admin.categories.create_modal')
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
