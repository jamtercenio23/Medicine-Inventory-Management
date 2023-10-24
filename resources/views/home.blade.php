@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

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
                                    <p class="card-text">Total Medicines: {{ $totalMedicines }}</p>
                                    <p class="card-text">Out of Stock Medicines: {{ $totalOutOfStockMedicines }}</p>
                                    <p class="card-text">Expired Medicines: {{ $totalExpiredMedicines }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Population Card -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Population</h5>
                                    <p class="card-text">Total Barangay: {{ $totalBarangay }}</p>
                                    <p class="card-text">Total Patients: {{ $totalPatients }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Distributions Card -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Distributions</h5>
                                    <p class="card-text">Total Barangay Distributions: {{ $totalBarangayDistributions }}</p>
                                    <p class="card-text">Total Patient Distributions: {{ $totalPatientDistributions }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
