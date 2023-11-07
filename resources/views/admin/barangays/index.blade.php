@extends('layouts.app')

@section('title', 'Medicine Inventory - Barangays')

@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Manage Barangays</h1>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createBarangayModal">
                <i class="fas fa-plus"></i> Add Barangay
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
        <div class="breadcrumb">
            <h5><a href="{{ route('home') }}">Dashboard</a> / Health Center Barangays</h5>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('barangays.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $query }}">
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
                <!-- Barangay Table -->
                <div class="table-responsive">
                    @if ($barangays->isEmpty())
                        <p>No barangays found.</p>
                    @else
                    <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangays as $barangay)
                                    <tr>
                                        <td>{{ $barangay->id }}</td>
                                        <td>{{ $barangay->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#showBarangayModal{{ $barangay->id }}">
                                                <i class="fas fa-eye"></i> Show
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editBarangayModal{{ $barangay->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteBarangayModal{{ $barangay->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @include('admin.barangays.show_modal', ['barangay' => $barangay])
                                    @include('admin.barangays.edit_modal', ['barangay' => $barangay])
                                    @include('admin.barangays.delete_modal', ['barangay' => $barangay])
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
                    <li class="page-item {{ $barangays->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $barangays->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @php
                        $currentPage = $barangays->currentPage();
                        $lastPage = $barangays->lastPage();
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
                            <a class="page-link" href="{{ $barangays->url(1) }}">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                    @endif
                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="{{ $barangays->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if ($showLastDots)
                        <li class="page-item disabled">
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $barangays->url($lastPage) }}">{{ $lastPage }}</a>
                        </li>
                    @endif
                    <li class="page-item {{ $barangays->currentPage() == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $barangays->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    @include('admin.barangays.create_modal')
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
