@extends('layouts.app')
@section('title', 'Medicine Inventory - Barangay Medicines')
@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Barangay Medicines</h1>
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
            <h5><a href="{{ route('home') }}">Dashboard</a> / Barangay Medicines</h5>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('barangay-medicines.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $query }}">
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
                    @if ($barangayMedicines->isEmpty())
                        <p>No medicines found for your barangay.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Barangay</th>
                                    <th>Medicine Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangayMedicines as $barangayMedicine)
                                    <tr>
                                        <td>{{ $barangayMedicine->id }}</td>
                                        <td>{{ $barangayMedicine->barangay->name }}</td>
                                        <td>{{ $barangayMedicine->medicine->generic_name }} - {{ $barangayMedicine->medicine->brand_name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#showbarangayMedicineModal{{ $barangayMedicine->id }}">
                                                <i class="fas fa-eye"></i> Show
                                            </button>
                                        </td>
                                        @include('barangay.barangay_medicines.show_modal', ['barangayMedicines' => $barangayMedicine])
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="float-right">
                    <ul class="pagination">
                        <li class="page-item {{ $barangayMedicines->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $barangayMedicines->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $barangayMedicines->lastPage(); $i++)
                            <li class="page-item {{ $i == $barangayMedicines->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $barangayMedicines->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $barangayMedicines->currentPage() == $barangayMedicines->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $barangayMedicines->nextPageUrl() }}" aria-label="Next">
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
        }
    </style>
@endsection
