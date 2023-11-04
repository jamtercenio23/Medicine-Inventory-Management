@extends('layouts.app')
@section('title', 'Medicine Inventory - Medicines')
@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Medicine Inventory</h1>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createMedicineModal">
                <i class="fas fa-plus"></i> Add Medicine
            </button>
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
            <h5><a href="{{ route('home') }}">Dashboard</a> / Medicines</h5>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('medicines.index') }}" method="GET" class="form-inline">
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
                    @if ($medicines->isEmpty())
                        <p>No medicines found.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Medicine Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medicines as $medicine)
                                    <tr>
                                        <td>{{ $medicine->id }}</td>
                                        <td>{{ $medicine->generic_name }} - {{ $medicine->brand_name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#showMedicineModal{{ $medicine->id }}">
                                                <i class="fas fa-eye"></i> Show
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editMedicineModal{{ $medicine->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteMedicineModal{{ $medicine->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Show Medicine Modal -->
                                    @include('admin.medicines.show_modal', ['medicine' => $medicine])

                                    <!-- Edit Medicine Modal -->
                                    @include('admin.medicines.edit_modal', ['medicine' => $medicine])

                                    <!-- Delete Medicine Modal -->
                                    @include('admin.medicines.delete_modal', ['medicine' => $medicine])
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="float-left"> <!-- You can add any additional content here if needed --> </div>
                <div class="float-right"> <!-- Bootstrap Pagination -->
                    <ul class="pagination">
                        <li class="page-item {{ $medicines->currentPage() == 1 ? 'disabled' : '' }}"> <a class="page-link"
                                href="{{ $medicines->previousPageUrl() }}" aria-label="Previous"> <span
                                    aria-hidden="true">&laquo;</span> </a> </li>
                        @for ($i = 1; $i <= $medicines->lastPage(); $i++)
                            <li class="page-item {{ $i == $medicines->currentPage() ? 'active' : '' }}"> <a
                                    class="page-link" href="{{ $medicines->url($i) }}">{{ $i }}</a> </li>
                        @endfor
                        <li class="page-item {{ $medicines->currentPage() == $medicines->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $medicines->nextPageUrl() }}" aria-label="Next"> <span
                                    aria-hidden="true">&raquo;</span> </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Create Medicine Modal -->
    @include('admin.medicines.create_modal')

    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Include Bootstrap CSS for pagination styles -->
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
