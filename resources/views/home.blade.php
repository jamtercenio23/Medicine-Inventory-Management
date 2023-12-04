@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="mb-8 d-flex justify-content-between align-items-center">
            <h1>Dashboard Updates</h1>
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
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Medicines</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalMedicines }}</p>
                                    </div>
                                    <i class="fas fa-pills" style="font-size: 36px; color: #3498db;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Out of Stock Medicines</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalOutOfStockMedicines }}</p>
                                    </div>
                                    <i class="fas fa-ban" style="font-size: 36px; color: #e74c3c;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Expired Medicines</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalExpiredMedicines }}</p>
                                    </div>
                                    <i class="fas fa-calendar-times" style="font-size: 36px; color: #f39c12;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Barangay Distributions</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalDistributionBarangay }}</p>
                                    </div>
                                    <i class="fas fa-hospital" style="font-size: 36px; color: #27ae60;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Patient Distributions</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalPatientDistributions }}</p>
                                    </div>
                                    <i class="fas fa-user-friends" style="font-size: 36px; color: #3498db;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Barangays</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalBarangay }}</p>
                                    </div>
                                    <i class="fas fa-city" style="font-size: 36px; color: #e74c3c;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Patients</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalPatients }}</p>
                                    </div>
                                    <i class="fas fa-user" style="font-size: 36px; color: #f39c12;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card card-scrollable">
                                <div class="card-body">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">Nearly Out of Stock Medicines</h5>
                                        <span
                                            style="font-weight: bold; font-size: 25px;">{{ $totalNearlyOutOfStockMedicines }}</span>
                                    </div>
                                    @if (count($nearlyOutOfStockMedicines) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Category</th>
                                                        <th>Stocks</th>
                                                        <th>Expiration Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nearlyOutOfStockMedicines as $medicine)
                                                        <tr>
                                                            <td>
                                                                {{ $medicine->generic_name }} -
                                                                {{ $medicine->brand_name }}
                                                            </td>
                                                            <td>
                                                                {{ $medicine->category->name }}
                                                            </td>
                                                            <td
                                                                style="background-color:
                                                                @if ($medicine->stocks >= 41 && $medicine->stocks <= 50) #FFD700
                                                                @elseif($medicine->stocks >= 21 && $medicine->stocks <= 40) #FFA500
                                                                @elseif($medicine->stocks >= 1 && $medicine->stocks <= 20) #FF6347 @endif;">
                                                                {{ $medicine->stocks }}
                                                            </td>
                                                            <td>
                                                                {{ $medicine->expiration_date }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            {{ $nearlyOutOfStockMedicines->appends(['tab' => 'out_of_stock_page'])->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                    @else
                                        <p class="text-center">No Nearly Out of Stock Medicines.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card card-scrollable">
                                <div class="card-body">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">Nearly Expired Medicines</h5>
                                        <span
                                            style="font-weight: bold; font-size: 25px;">{{ $totalNearlyExpiredMedicines }}</span>
                                    </div>
                                    @if (count($nearlyExpiredMedicines) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Category</th>
                                                        <th>Stocks</th>
                                                        <th>Expiration Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nearlyExpiredMedicines as $medicine)
                                                        <tr>
                                                            <td>
                                                                {{ $medicine->generic_name }} -
                                                                {{ $medicine->brand_name }}
                                                            </td>
                                                            <td>
                                                                {{ $medicine->category->name }}
                                                            </td>
                                                            <td>
                                                                {{ $medicine->stocks }}
                                                            </td>
                                                            <td
                                                                style="background-color:
                                                                @if (strtotime($medicine->expiration_date) - strtotime(now()) > 10 * 24 * 3600) default
                                                                @elseif(strtotime($medicine->expiration_date) - strtotime(now()) > 7 * 24 * 3600) #FFD700
                                                                @elseif(strtotime($medicine->expiration_date) - strtotime(now()) > 4 * 24 * 3600) #FFA500
                                                                @elseif(strtotime($medicine->expiration_date) - strtotime(now()) > 1 * 24 * 3600) #FF6347 @endif;">
                                                                {{ $medicine->expiration_date }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            {{ $nearlyExpiredMedicines->appends(['tab' => 'expired_page'])->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                    @else
                                        <p class="text-center">No Nearly Expired Medicines.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card card-scrollable">
                                <div class="card-body">
                                    <h5 class="card-title">Schedules for Distribution This Week</h5>
                                    @if (count($distributionSchedulesThisWeek) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Barangay</th>
                                                        <th>Medicine</th>
                                                        <th>Stocks</th>
                                                        <th>Schedule Date/Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($distributionSchedulesThisWeek as $schedule)
                                                        <tr>
                                                            <td>{{ $schedule->barangay->name }}</td>
                                                            <td>{{ $schedule->medicine->generic_name }} -
                                                                {{ $schedule->medicine->brand_name }}</td>
                                                            <td>{{ $schedule->stock }}</td>
                                                            <td>{{ is_string($schedule->schedule_date_time) ? $schedule->schedule_date_time : $schedule->schedule_date_time->format('Y-m-d H:i:s') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            {{ $distributionSchedulesThisWeek->appends(['tab' => 'this_week_page'])->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                    @else
                                        <p class="text-center">No Distribution Schedules for this week.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card card-scrollable">
                                <div class="card-body">
                                    <h5 class="card-title">Schedule for Distribution Today</h5>
                                    @if (count($distributionSchedulesToday) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Barangay</th>
                                                        <th>Medicine</th>
                                                        <th>Stocks</th>
                                                        <th>Schedule Date/Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($distributionSchedulesToday as $schedule)
                                                        <tr>
                                                            <td>{{ $schedule->barangay->name }}</td>
                                                            <td>{{ $schedule->medicine->generic_name }} -
                                                                {{ $schedule->medicine->brand_name }}</td>
                                                            <td>{{ $schedule->stock }}</td>
                                                            <td>{{ $schedule->schedule_date_time }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            {{ $distributionSchedulesToday->appends(['tab' => 'today_page'])->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                    @else
                                        <p class="text-center">No Distribution Schedules for today.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif (Auth::user()->isBHW())
                    <!-- BHW Dashboard -->
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Medicines</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalBarangayMedicines }}</p>
                                    </div>
                                    <i class="fas fa-pills" style="font-size: 36px; color: #3498db;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Out of Stock Medicines</h5>
                                        <p class="card-text" style="font-size: 24px;">
                                            {{ $totalBarangayOutOfStockMedicines }}</p>
                                    </div>
                                    <i class="fas fa-ban" style="font-size: 36px; color: #e74c3c;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Expired Medicines</h5>
                                        <p class="card-text" style="font-size: 24px;">
                                            {{ $totalBarangayExpiredMedicines }}</p>
                                    </div>
                                    <i class="fas fa-calendar-times" style="font-size: 36px; color: #f39c12;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Distributions</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalBarangayDistributions }}
                                        </p>
                                    </div>
                                    <i class="fas fa-hospital" style="font-size: 36px; color: #27ae60;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Patients</h5>
                                        <p class="card-text" style="font-size: 24px;">{{ $totalBarangayPatients }}</p>
                                    </div>
                                    <i class="fas fa-user" style="font-size: 36px; color: #f39c12;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card card-scrollable">
                                    <div class="card-body">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">Nearly Out of Stock Medicines</h5>
                                            <span
                                                style="font-weight: bold; font-size: 25px;">{{ $totalNearlyBarangayOutOfStockMedicines }}</span>
                                        </div>
                                        @if (count($nearlyBarangayOutOfStockMedicines) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Category</th>
                                                            <th>Stocks</th>
                                                            <th>Expiration Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($nearlyBarangayOutOfStockMedicines as $barangayMedicine)
                                                            <tr>
                                                                <td>{{ $barangayMedicine->generic_name }} -
                                                                    {{ $barangayMedicine->brand_name }}</td>
                                                                <td>{{ $barangayMedicine->medicine->category->name }}</td>
                                                                <td
                                                                    style="background-color:
                                                                @if ($barangayMedicine->stocks >= 41 && $barangayMedicine->stocks <= 50) #FFD700
                                                                @elseif($barangayMedicine->stocks >= 21 && $barangayMedicine->stocks <= 40) #FFA500
                                                                @elseif($barangayMedicine->stocks >= 1 && $barangayMedicine->stocks <= 20) #FF6347 @endif;">
                                                                    {{ $barangayMedicine->stocks }}</td>
                                                                <td>{{ $barangayMedicine->expiration_date }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                {{ $nearlyBarangayOutOfStockMedicines->appends(['tab' => 'out_of_stock_page'])->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        @else
                                            <p class="text-center">No Nearly Out of Stock Medicines.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card card-scrollable">
                                    <div class="card-body">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">Nearly Expired Medicines</h5>
                                            <span
                                                style="font-weight: bold; font-size: 25px;">{{ $totalNearlyBarangayExpiredMedicines }}</span>
                                        </div>
                                        @if (count($nearlyBarangayExpiredMedicines) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Category</th>
                                                            <th>Stocks</th>
                                                            <th>Expiration Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($nearlyBarangayExpiredMedicines as $barangayMedicine)
                                                            <tr>
                                                                <td>{{ $barangayMedicine->generic_name }} -
                                                                    {{ $barangayMedicine->brand_name }}</td>
                                                                <td>{{ $barangayMedicine->medicine->category->name }}</td>
                                                                <td>{{ $barangayMedicine->stocks }}</td>
                                                                <td style="background-color:
                                                                @if(strtotime($barangayMedicine->expiration_date) - strtotime(now()) > 10 * 24 * 3600) default
                                                                @elseif(strtotime($barangayMedicine->expiration_date) - strtotime(now()) > 7 * 24 * 3600) #FFD700
                                                                @elseif(strtotime($barangayMedicine->expiration_date) - strtotime(now()) > 4 * 24 * 3600) #FFA500
                                                                @elseif(strtotime($barangayMedicine->expiration_date) - strtotime(now()) > 1 * 24 * 3600) #FF6347
                                                                @endif;">{{ $barangayMedicine->expiration_date }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                {{ $nearlyBarangayExpiredMedicines->appends(['tab' => 'expired_page'])->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        @else
                                            <p class="text-center">No Nearly Expired Medicines.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card card-scrollable">
                                    <div class="card-body">
                                        <h5 class="card-title">Distribution Schedules in Your Barangay This Week</h5>
                                        @if (count($distributionSchedulesInYourBarangay) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Medicine</th>
                                                            <th>Stocks</th>
                                                            <th>Schedule Date/Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($distributionSchedulesInYourBarangay as $schedule)
                                                            <tr>
                                                                <td>{{ $schedule->medicine->generic_name }} -
                                                                    {{ $schedule->medicine->brand_name }}</td>
                                                                <td>{{ $schedule->stock }}</td>
                                                                <td>{{ is_string($schedule->schedule_date_time) ? $schedule->schedule_date_time : $schedule->schedule_date_time->format('Y-m-d H:i:s') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                {{ $distributionSchedulesInYourBarangay->appends(['tab' => 'this_week_page'])->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        @else
                                            <p class="text-center">No distribution schedules for your barangay this week.
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card card-scrollable">
                                    <div class="card-body">
                                        <h5 class="card-title">Newly Added Medicines in Your Barangay</h5>
                                        @if (count($newlyAddedBarangayMedicines) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Category</th>
                                                            <th>Stocks</th>
                                                            <th>Expiration Date</th>
                                                            <th>Distributed Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($newlyAddedBarangayMedicines as $barangayMedicine)
                                                            <tr>
                                                                <td>{{ $barangayMedicine->medicine->generic_name }} -
                                                                    {{ $barangayMedicine->medicine->brand_name }}</td>
                                                                <td>{{ $barangayMedicine->medicine->category->name }}</td>
                                                                <td>{{ $barangayMedicine->stocks }}</td>
                                                                <td>{{ $barangayMedicine->expiration_date }}</td>
                                                                <td>{{ $barangayMedicine->created_at }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                {{ $newlyAddedBarangayMedicines->appends(['tab' => 'newly_page'])->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        @else
                                            <p class="text-center">No Newly Added Medicines in Your Barangay.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif (Auth::user()->isPharmacist())
                        <!-- Pharmacist Dashboard -->
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Total Medicines</h5>
                                            <p class="card-text" style="font-size: 24px;">{{ $totalMedicines }}</p>
                                        </div>
                                        <i class="fas fa-pills" style="font-size: 36px; color: #3498db;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Out of Stock Medicines</h5>
                                            <p class="card-text" style="font-size: 24px;">{{ $totalOutOfStockMedicines }}
                                            </p>
                                        </div>
                                        <i class="fas fa-ban" style="font-size: 36px; color: #e74c3c;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Expired Medicines</h5>
                                            <p class="card-text" style="font-size: 24px;">{{ $totalExpiredMedicines }}
                                            </p>
                                        </div>
                                        <i class="fas fa-calendar-times" style="font-size: 36px; color: #f39c12;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Total Barangay Distributions</h5>
                                            <p class="card-text" style="font-size: 24px;">
                                                {{ $totalDistributionBarangay }}</p>
                                        </div>
                                        <i class="fas fa-hospital" style="font-size: 36px; color: #27ae60;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Total Patient Distributions</h5>
                                            <p class="card-text" style="font-size: 24px;">
                                                {{ $totalPatientDistributions }}</p>
                                        </div>
                                        <i class="fas fa-user-friends" style="font-size: 36px; color: #3498db;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Total Barangays</h5>
                                            <p class="card-text" style="font-size: 24px;">{{ $totalBarangay }}</p>
                                        </div>
                                        <i class="fas fa-city" style="font-size: 36px; color: #e74c3c;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Total Patients</h5>
                                            <p class="card-text" style="font-size: 24px;">{{ $totalPatients }}</p>
                                        </div>
                                        <i class="fas fa-user" style="font-size: 36px; color: #f39c12;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card card-scrollable">
                                    <div class="card-body">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">Nearly Out of Stock Medicines</h5>
                                            <span
                                                style="font-weight: bold; font-size: 25px;">{{ $totalNearlyOutOfStockMedicines }}</span>
                                        </div>
                                        @if (count($nearlyOutOfStockMedicines) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Category</th>
                                                            <th>Stocks</th>
                                                            <th>Expiration Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($nearlyOutOfStockMedicines as $medicine)
                                                            <tr>
                                                                <td>
                                                                    {{ $medicine->generic_name }} -
                                                                    {{ $medicine->brand_name }}
                                                                </td>
                                                                <td>
                                                                    {{ $medicine->category->name }}
                                                                </td>
                                                                <td
                                                                    style="background-color:
                                                                    @if ($medicine->stocks >= 41 && $medicine->stocks <= 50) #FFD700
                                                                    @elseif($medicine->stocks >= 21 && $medicine->stocks <= 40) #FFA500
                                                                    @elseif($medicine->stocks >= 1 && $medicine->stocks <= 20) #FF6347 @endif;">
                                                                    {{ $medicine->stocks }}
                                                                </td>
                                                                <td>
                                                                    {{ $medicine->expiration_date }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                {{ $nearlyOutOfStockMedicines->appends(['tab' => 'out_of_stock_page'])->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        @else
                                            <p class="text-center">No Nearly Out of Stock Medicines.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card card-scrollable">
                                    <div class="card-body">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">Nearly Expired Medicines</h5>
                                            <span
                                                style="font-weight: bold; font-size: 25px;">{{ $totalNearlyExpiredMedicines }}</span>
                                        </div>
                                        @if (count($nearlyExpiredMedicines) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Category</th>
                                                            <th>Stocks</th>
                                                            <th>Expiration Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($nearlyExpiredMedicines as $medicine)
                                                            <tr>
                                                                <td>
                                                                    {{ $medicine->generic_name }} -
                                                                    {{ $medicine->brand_name }}
                                                                </td>
                                                                <td>
                                                                    {{ $medicine->category->name }}
                                                                </td>
                                                                <td>
                                                                    {{ $medicine->stocks }}
                                                                </td>
                                                                <td
                                                                    style="background-color:
                                                                    @if (strtotime($medicine->expiration_date) - strtotime(now()) > 10 * 24 * 3600) default
                                                                    @elseif(strtotime($medicine->expiration_date) - strtotime(now()) > 7 * 24 * 3600) #FFD700
                                                                    @elseif(strtotime($medicine->expiration_date) - strtotime(now()) > 4 * 24 * 3600) #FFA500
                                                                    @elseif(strtotime($medicine->expiration_date) - strtotime(now()) > 1 * 24 * 3600) #FF6347 @endif;">
                                                                    {{ $medicine->expiration_date }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                {{ $nearlyExpiredMedicines->appends(['tab' => 'expired_page'])->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        @else
                                            <p class="text-center">No Nearly Expired Medicines.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card card-scrollable">
                                    <div class="card-body">
                                        <h5 class="card-title">Schedules for Distribution This Week</h5>
                                        @if (count($distributionSchedulesThisWeek) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Barangay</th>
                                                            <th>Medicine</th>
                                                            <th>Stocks</th>
                                                            <th>Schedule Date/Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($distributionSchedulesThisWeek as $schedule)
                                                            <tr>
                                                                <td>{{ $schedule->barangay->name }}</td>
                                                                <td>{{ $schedule->medicine->generic_name }} -
                                                                    {{ $schedule->medicine->brand_name }}</td>
                                                                <td>{{ $schedule->stock }}</td>
                                                                <td>{{ is_string($schedule->schedule_date_time) ? $schedule->schedule_date_time : $schedule->schedule_date_time->format('Y-m-d H:i:s') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                {{ $distributionSchedulesThisWeek->appends(['tab' => 'this_week_page'])->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        @else
                                            <p class="text-center">No Distribution Schedules for this week.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card card-scrollable">
                                    <div class="card-body">
                                        <h5 class="card-title">Schedule for Distribution Today</h5>
                                        @if (count($distributionSchedulesToday) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Barangay</th>
                                                            <th>Medicine</th>
                                                            <th>Stocks</th>
                                                            <th>Schedule Date/Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($distributionSchedulesToday as $schedule)
                                                            <tr>
                                                                <td>{{ $schedule->barangay->name }}</td>
                                                                <td>{{ $schedule->medicine->generic_name }} -
                                                                    {{ $schedule->medicine->brand_name }}</td>
                                                                <td>{{ $schedule->stock }}</td>
                                                                <td>{{ $schedule->schedule_date_time }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                {{ $distributionSchedulesToday->appends(['tab' => 'today_page'])->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        @else
                                            <p class="text-center">No Distribution Schedules for today.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif (Auth::user()->isSuperAdmin())
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Total Users</h5>
                                            <p class="card-text" style="font-size: 24px;">{{ $totalUsers }}</p>
                                        </div>
                                        <i class="fas fa-users" style="font-size: 36px; color: #27ae60;"></i>
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
            background: transparent;
        }

        .card-scrollable {
            scrollbar-width: thin;
            overflow-y: scroll;
        }

        .card-scrollable {
            max-height: 400px;
            overflow-y: auto;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-bottom: 5px;
        }

        .pagination {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .pagination li {
            display: inline;
            margin-right: 5px;
        }

        .pagination a {
            text-decoration: none;
            border: 1px solid #007bff;
            color: #007bff;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

        body.dark-mode .card {
            background-color: #343a40;
            color: #ffffff;
        }

        body.dark-mode .table {
            background-color: #2d2d2d;
            color: #fff;
        }

        body.dark-mode .table th {
            background-color: #1e1e1e;
            color: #fff;
        }

        body.dark-mode .table th,
        body.dark-mode .table td {
            border: 1px solid #333;
            background-color: #2d2d2d;
            color: #fff;
        }

        body.dark-mode .pagination a {
            text-decoration: none;
            color: #007bff;
            background-color: #343a40;
        }

        body.dark-mode .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

        body.dark-mode .pagination .page-item:first-child .page-link,
        body.dark-mode .pagination .page-item:last-child .page-link {
            border: 1px solid #007bff;
            color: #007bff;
            background-color: #343a40;
        }

        body.dark-mode .pagination .page-item:first-child .page-link:hover,
        body.dark-mode .pagination .page-item:last-child .page-link:hover {
            background-color: #007bff;
            color: #fff;
        }

        body.dark-mode .pagination .page-item.disabled .page-link {
            background-color: #343a40;
            color: #6c757d;
            border: 1px solid #343a40;
        }

        body.dark-mode .form-control {
            background-color: #2d2d2d;
            color: #fff;
        }
    </style>
    <script>
        const isDarkMode = localStorage.getItem('dark_mode') === 'true';

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
