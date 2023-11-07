@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Dashboard</h1>
        </div>
        <div class="card">

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <h4 class="mb-4">Welcome, {{ Auth::user()->name }}!</h4>

                <div class="row">
                    <!-- Medicines Card -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Medicines</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Total Medicines: {{ $totalMedicines }}</li>
                                    <li class="list-group-item">Out of Stock Medicines:
                                        {{ $totalOutOfStockMedicines }}</li>
                                    <li class="list-group-item">Expired Medicines: {{ $totalExpiredMedicines }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Population Card -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Population</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Total Barangays: {{ $totalBarangay }}</li>
                                    <li class="list-group-item">Total Patients: {{ $totalPatients }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Distributions Card -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Distributions</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Total Barangay Distributions:
                                        {{ $totalBarangayDistributions }}</li>
                                    <li class="list-group-item">Total Patient Distributions:
                                        {{ $totalPatientDistributions }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <style>
        /* Add custom CSS styles here */
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .list-group-item {
            transition: background-color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f0f0f0;
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #218838;
        }


        .btn-secondary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>

    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrap.com/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
