@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Notification Updates</h1>
        </div>
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <h4 class="mb-4">Welcome, {{ Auth::user()->name }}!</h4>

                @if (Auth::user()->isAdmin())
                    <!-- Admin Dashboard -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Medicines</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Medicines: {{ $totalMedicines }}</li>
                                        <li class="list-group-item">Out of Stock Medicines: {{ $totalOutOfStockMedicines }}
                                        </li>
                                        <li class="list-group-item">Nearly Out of Stock Medicines:
                                            {{ $totalNearlyOutOfStockMedicines }}</li>
                                        <li class="list-group-item">Expired Medicines: {{ $totalExpiredMedicines }}</li>
                                        <li class="list-group-item">Nearly Expired Medicines:
                                            {{ $totalNearlyExpiredMedicines }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Distributions</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Barangay Distributions:
                                            {{ $totalDistributionBarangay }}</li>
                                        <li class="list-group-item">Total Barangay Distributions added today:
                                            {{ $totalBarangayDistributionAddedToday }}</li>
                                        <li class="list-group-item">Total Patient Distributions:
                                            {{ $totalPatientDistributions }}</li>
                                        <li class="list-group-item">Total Patient Distributions added today:
                                            {{ $totalPatientDistributionAddedToday }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Population</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Barangays: {{ $totalBarangay }}</li>
                                        <li class="list-group-item">Total Patients: {{ $totalPatients }}</li>
                                        <li class="list-group-item">Total Patients added today:
                                            {{ $totalPatientsAddedToday }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4 card-scrollable">
                                <div class="card-body">
                                    <h5 class="card-title">Nearly Out of Stock Medicines</h5>
                                    <ul class="list-group list-group-flush">
                                        @foreach ($nearlyOutOfStockMedicines as $medicine)
                                            <li class="list-group-item">
                                                <strong>Name:</strong> {{ $medicine->generic_name }} - {{ $medicine->brand_name }}<br>
                                                <strong>Category:</strong> {{ $medicine->category->name }}<br>
                                                <strong>Stocks:</strong> {{ $medicine->stocks }}<br>
                                                <strong>Expiration Date:</strong> {{ $medicine->expiration_date }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4 card-scrollable">
                                <div class="card-body">
                                    <h5 class="card-title">Nearly Expired Medicines</h5>
                                    <ul class="list-group list-group-flush">
                                        @foreach ($nearlyExpiredMedicines as $medicine)
                                            <li class="list-group-item">
                                                <strong>Name:</strong> {{ $medicine->generic_name }} - {{ $medicine->brand_name }}<br>
                                                <strong>Category:</strong> {{ $medicine->category->name }}<br>
                                                <strong>Stocks:</strong> {{ $medicine->stocks }}<br>
                                                <strong>Expiration Date:</strong> {{ $medicine->expiration_date }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body card-scrollable">
                                    <h5 class="card-title">Schedules for Distribution This Week</h5>
                                    <ul class="list-group list-group-flush">
                                        @forelse ($distributionSchedulesThisWeek as $schedule)
                                            <li class="list-group-item">
                                                <strong>Barangay:</strong> {{ $schedule->barangay->name }}<br>
                                                <strong>Medicine:</strong> {{ $schedule->medicine->generic_name }} -
                                                {{ $schedule->medicine->generic_name }}<br>
                                                <strong>Stocks:</strong> {{ $schedule->stock }}<br>
                                                <strong>Schedule Date:</strong>
                                                {{ is_string($schedule->schedule_date_time) ? $schedule->schedule_date_time : $schedule->schedule_date_time->format('Y-m-d H:i:s') }}
                                            </li>
                                        @empty
                                            <li class="list-group-item">No distribution schedules for this week.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Schedule for Distribution Today</h5>
                                    <ul class="list-group list-group-flush">
                                        @forelse ($distributionSchedulesToday as $schedule)
                                            <li class="list-group-item">
                                                <strong>Barangay:</strong> {{ $schedule->barangay->name }}<br>
                                                <strong>Medicine:</strong> {{ $schedule->medicine->generic_name }} -
                                                {{ $schedule->medicine->brand_name }}<br>
                                                <strong>Stocks:</strong> {{ $schedule->stock }}
                                            </li>
                                        @empty
                                            <li class="list-group-item">No distribution schedules for today.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif (Auth::user()->isBHW())
                    <!-- BHW Dashboard -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Medicines</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Medicines: {{ $totalBarangayMedicines }}</li>
                                        <li class="list-group-item">Out of Stock Medicines: {{ $totalOutOfStockMedicines }}
                                        </li>
                                        <li class="list-group-item">Nearly Out of Stock Medicines:
                                            {{ $totalNearlyOutOfStockMedicines }}</li>
                                        <li class="list-group-item">Expired Medicines: {{ $totalExpiredMedicines }}</li>
                                        <li class="list-group-item">Nearly Expired Medicines:
                                            {{ $totalNearlyExpiredMedicines }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Distributions</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Distributions: {{ $totalBarangayDistributions }}
                                        </li>
                                        <li class="list-group-item">Total Distributions added today:
                                            {{ $totalDistributionAddedToday }}</li>
                                        <!-- Add other BHW-specific distribution details here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Population</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Patients: {{ $totalBarangayPatients }}</li>
                                        <li class="list-group-item">Total Patients added today:
                                            {{ $totalPatientsAddedToday }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body card-scrollable">
                                    <h5 class="card-title">Nearly Out of Stock Medicines in Your Barangay</h5>
                                    @if (count($nearlyOutOfStockMedicines) > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($nearlyOutOfStockMedicines as $barangayMedicine)
                                                <li class="list-group-item">
                                                    <strong>Name:</strong> {{ $barangayMedicine->generic_name }} - {{ $barangayMedicine->brand_name }}<br>
                                                    <strong>Category:</strong> {{ $barangayMedicine->medicine->category->name }}<br>
                                                    <strong>Stocks:</strong> {{ $barangayMedicine->stocks }}<br>
                                                    <strong>Expiration Date:</strong> {{ $barangayMedicine->expiration_date }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No Nearly Out of Stock Medicines in Your Barangay.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body card-scrollable">
                                    <h5 class="card-title">Nearly Expired Medicines in Your Barangay</h5>
                                    @if (count($nearlyExpiredMedicines) > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($nearlyExpiredMedicines as $barangayMedicine)
                                                <li class="list-group-item">
                                                    <strong>Name:</strong> {{ $barangayMedicine->generic_name }} - {{ $barangayMedicine->brand_name }}<br>
                                                    <strong>Category:</strong> {{ $barangayMedicine->medicine->category->name }}<br>
                                                    <strong>Stocks:</strong> {{ $barangayMedicine->stocks }}<br>
                                                    <strong>Expiration Date:</strong> {{ $barangayMedicine->expiration_date }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No Nearly Expired Medicines in Your Barangay.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body card-scrollable">
                                    <h5 class="card-title">Distribution Schedules in Your Barangay This Week</h5>
                                    <ul class="list-group list-group-flush">
                                        @forelse ($distributionSchedulesInYourBarangay as $schedule)
                                            <li class="list-group-item">
                                                <strong>Medicine:</strong> {{ $schedule->medicine->generic_name }} -
                                                {{ $schedule->medicine->brand_name }}<br>
                                                <strong>Stocks:</strong> {{ $schedule->stock }}<br>
                                                <strong>Schedule Date:</strong>
                                                {{ is_string($schedule->schedule_date_time) ? $schedule->schedule_date_time : $schedule->schedule_date_time->format('Y-m-d H:i:s') }}
                                            </li>
                                        @empty
                                            <li class="list-group-item">No distribution schedules for your barangay this week.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif (Auth::user()->isPharmacist())
                    <!-- Pharmacist Dashboard -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Medicines</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Medicines: {{ $totalMedicines }}</li>
                                        <li class="list-group-item">Out of Stock Medicines: {{ $totalOutOfStockMedicines }}
                                        </li>
                                        <li class="list-group-item">Nearly Out of Stock Medicines:
                                            {{ $totalNearlyOutOfStockMedicines }}</li>
                                        <li class="list-group-item">Expired Medicines: {{ $totalExpiredMedicines }}</li>
                                        <li class="list-group-item">Nearly Expired Medicines:
                                            {{ $totalNearlyExpiredMedicines }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Distributions</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Barangay Distributions:
                                            {{ $totalDistributionBarangay }}</li>
                                        <li class="list-group-item">Total Barangay Distributions added today:
                                            {{ $totalBarangayDistributionAddedToday }}</li>
                                        <li class="list-group-item">Total Patient Distributions:
                                            {{ $totalPatientDistributions }}</li>
                                        <li class="list-group-item">Total Patient Distributions added today:
                                            {{ $totalPatientDistributionAddedToday }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Population</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Barangays: {{ $totalBarangay }}</li>
                                        <li class="list-group-item">Total Patients: {{ $totalPatients }}</li>
                                        <li class="list-group-item">Total Patients added today:
                                            {{ $totalPatientsAddedToday }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4 card-scrollable">
                                <div class="card-body">
                                    <h5 class="card-title">Nearly Out of Stock Medicines</h5>
                                    <ul class="list-group list-group-flush">
                                        @foreach ($nearlyOutOfStockMedicines as $medicine)
                                            <li class="list-group-item">
                                                <strong>Name:</strong> {{ $medicine->generic_name }} - {{ $medicine->brand_name }}<br>
                                                <strong>Category:</strong> {{ $medicine->category->name }}<br>
                                                <strong>Stocks:</strong> {{ $medicine->stocks }}<br>
                                                <strong>Expiration Date:</strong> {{ $medicine->expiration_date }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4 card-scrollable">
                                <div class="card-body">
                                    <h5 class="card-title">Nearly Expired Medicines</h5>
                                    <ul class="list-group list-group-flush">
                                        @foreach ($nearlyExpiredMedicines as $medicine)
                                            <li class="list-group-item">
                                                <strong>Name:</strong> {{ $medicine->generic_name }} - {{ $medicine->brand_name }}<br>
                                                <strong>Category:</strong> {{ $medicine->category->name }}<br>
                                                <strong>Stocks:</strong> {{ $medicine->stocks }}<br>
                                                <strong>Expiration Date:</strong> {{ $medicine->expiration_date }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body card-scrollable">
                                    <h5 class="card-title">Schedules for Distribution This Week</h5>
                                    <ul class="list-group list-group-flush">
                                        @forelse ($distributionSchedulesThisWeek as $schedule)
                                            <li class="list-group-item">
                                                <strong>Barangay:</strong> {{ $schedule->barangay->name }}<br>
                                                <strong>Medicine:</strong> {{ $schedule->medicine->generic_name }} -
                                                {{ $schedule->medicine->generic_name }}<br>
                                                <strong>Stocks:</strong> {{ $schedule->stock }}<br>
                                                <strong>Schedule Date:</strong>
                                                {{ is_string($schedule->schedule_date_time) ? $schedule->schedule_date_time : $schedule->schedule_date_time->format('Y-m-d H:i:s') }}
                                            </li>
                                        @empty
                                            <li class="list-group-item">No distribution schedules for this week.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Schedule for Distribution Today</h5>
                                    <ul class="list-group list-group-flush">
                                        @forelse ($distributionSchedulesToday as $schedule)
                                            <li class="list-group-item">
                                                <strong>Barangay:</strong> {{ $schedule->barangay->name }}<br>
                                                <strong>Medicine:</strong> {{ $schedule->medicine->generic_name }} -
                                                {{ $schedule->medicine->brand_name }}<br>
                                                <strong>Stocks:</strong> {{ $schedule->stock }}
                                            </li>
                                        @empty
                                            <li class="list-group-item">No distribution schedules for today.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .card-scrollable::-webkit-scrollbar {
            width: 0;
            /* Remove scrollbar space */
            background: transparent;
            /* Optional: just make scrollbar invisible */
        }

        .card-scrollable {
            scrollbar-width: thin;
            /* For Firefox */
            overflow-y: scroll;
            /* Force scroll */
        }

        .card-scrollable {
            max-height: 300px;
            /* Set a maximum height for the card */
            overflow-y: auto;
        }

        .card {
            /* Optional: Set a fixed or max-height for the card */
            /* max-height: 400px; */
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-bottom: 20px;
        }

        .list-group-item {
            transition: background-color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f0f0f0;
        }
        .row .card {
                    height: 90%;
                }
        /* Dark mode styles */
        body.dark-mode .card {
            background-color: #343a40;
            /* Dark background color for cards in dark mode */
            color: #ffffff;
            /* Text color for cards in dark mode */
        }

        body.dark-mode .list-group-item {
            background-color: #343a40;
            color: #ffffff;
            /* Text color for list items in dark mode */
        }
    </style>
    <script>
        // Check if dark mode is enabled in local storage
        const isDarkMode = localStorage.getItem('dark_mode') === 'true';

        // Apply dark mode styles if enabled
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
        }
    </script>
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrap.com/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
