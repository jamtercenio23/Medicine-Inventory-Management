@extends('layouts.app')

@section('title', 'Medicine Inventory - Distributions')

@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Patient Distribution</h1>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createDistributionModal">
                <i class="fas fa-plus"></i> Add Distribution
            </button>
        </div>

        <!-- Display alert message if present -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h5><a href="{{ route('home') }}">Dashboard</a> / Distributions</h5>

        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <form action="{{ route('distributions.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search"
                                value="{{ $query }}">
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
                <!-- Display message when there are no distributions -->
                @if ($distributions->isEmpty())
                    <p>No distributions found.</p>
                @else
                    <!-- Distribution Table -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($distributions as $distribution)
                                <tr>
                                    <td>{{ $distribution->id }}</td>
                                    <td>{{ $distribution->patient->first_name }} {{ $distribution->patient->last_name }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#showDistributionModal{{ $distribution->id }}">
                                            <i class="fas fa-eye"></i> Show</button>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editDistributionModal{{ $distribution->id }}">
                                            <i class="fas fa-edit"></i> Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteDistributionModal{{ $distribution->id }}">
                                            <i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>

                                <!-- Show Distribution Modal -->
                                @include('admin.distributions.show_modal', [
                                    'distribution' => $distribution,
                                ])

                                <!-- Edit Distribution Modal -->
                                @include('admin.distributions.edit_modal', [
                                    'distribution' => $distribution,
                                ])

                                <!-- Delete Distribution Modal -->
                                @include('admin.distributions.delete_modal', [
                                    'distribution' => $distribution,
                                ])
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="card-footer text-muted">
                <div class="float-left">
                    <!-- You can add any additional content here if needed -->
                </div>
                <div class="float-right">
                    <!-- Bootstrap Pagination -->
                    <ul class="pagination">
                        <li class="page-item {{ $distributions->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $distributions->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $distributions->lastPage(); $i++)
                            <li class="page-item {{ $i == $distributions->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $distributions->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li
                            class="page-item {{ $distributions->currentPage() == $distributions->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $distributions->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @include('admin.distributions.create_modal')
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
