@extends('layouts.app')
@section('title', 'Medicine Inventory - Expired Medicines')
@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Expired Medicines</h1>
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
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <!-- Search Form -->
                    <form action="{{ route('medicines.expired') }}" method="GET" class="form-inline">
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
                    @if ($expiredMedicines->isEmpty())
                        <p>No expired medicines found.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Medicine Name</th>
                                    <th>Expiration Date</th>
                                    <th>Actions</th> <!-- Added Actions column -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expiredMedicines as $medicine)
                                    <tr>
                                        <td>{{ $medicine->id }}</td>
                                        <td>{{ $medicine->generic_name }} - {{ $medicine->brand_name }}</td>
                                        <td>{{ $medicine->expiration_date }}</td>
                                        <td>
                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteExpiredModal{{ $medicine->id }}"><i
                                                    class="fas fa-trash"></i> Delete</button>
                                        </td>
                                    </tr>
                                    <!-- Delete Expired Medicine Modal -->
                                    @include('admin.medicines.delete_expired_modal', [
                                        'medicine' => $medicine,
                                    ])
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
                        <li class="page-item {{ $expiredMedicines->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $expiredMedicines->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $expiredMedicines->lastPage(); $i++)
                            <li class="page-item {{ $i == $expiredMedicines->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $expiredMedicines->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li
                            class="page-item {{ $expiredMedicines->currentPage() == $expiredMedicines->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $expiredMedicines->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection

<!-- Include Bootstrap CSS for pagination styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
