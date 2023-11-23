<?php

namespace App\Http\Controllers;

use App\Models\DistributionBarangay;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Barangay;
use App\Models\BarangayMedicine;
use App\Models\Distribution;
use App\Models\BarangayDistribution;
use App\Models\BarangayPatient;
use App\Models\Schedule;
use Charts;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\Classes\Chart;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check user role and filter data accordingly
        if ($user->isAdmin()) {
            // Admin Dashboard logic
            $totalMedicines = Medicine::count();
            $totalPatients = Patient::count();
            $totalPatientsAddedToday = Patient::whereDate('created_at', today())->count();
            $totalBarangay = Barangay::count();
            $totalDistributionBarangay = DistributionBarangay::count();
            $totalPatientDistributions = Distribution::count();
            $totalOutOfStockMedicines = Medicine::where('stocks', 0)->count();
            $totalExpiredMedicines = Medicine::where('expiration_date', '<', now())->count();
            $totalNearlyOutOfStockMedicines = Medicine::where('stocks', '>', 1)
                ->where('stocks', '<=', 50)
                ->count();
            $totalNearlyExpiredMedicines = Medicine::where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->count();
            $totalPatientDistributionAddedToday = Distribution::whereDate('created_at', today())->count();
            $totalBarangayDistributionAddedToday = DistributionBarangay::whereDate('created_at', today())->count();
            $distributionSchedulesToday = Schedule::with(['barangay', 'medicine'])
                ->whereDate('schedule_date_time', today())
                ->get();
            $distributionSchedulesThisWeek = Schedule::with(['barangay', 'medicine'])
                ->whereBetween('schedule_date_time', [now()->startOfWeek(), now()->endOfWeek()])
                ->get();
            $nearlyOutOfStockMedicines = Medicine::where('stocks', '>', 1)
                ->where('stocks', '<=', 50)
                ->get(); // Fetch all nearly out of stock medicines

            $nearlyExpiredMedicines = Medicine::where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->get();
            return view('home', compact(
                'totalMedicines',
                'totalPatients',
                'totalPatientsAddedToday',
                'totalBarangay',
                'totalDistributionBarangay',
                'totalPatientDistributions',
                'totalOutOfStockMedicines',
                'totalExpiredMedicines',
                'totalNearlyOutOfStockMedicines',
                'totalNearlyExpiredMedicines',
                'totalPatientDistributionAddedToday',
                'totalBarangayDistributionAddedToday',
                'distributionSchedulesToday',
                'distributionSchedulesThisWeek',
                'nearlyOutOfStockMedicines',
                'nearlyExpiredMedicines',
            ));
        } elseif ($user->isBHW()) {
            // Get the BHW's barangay ID
            $barangayId = $user->barangay->id;

            // Count total barangay medicines, patients, and distributions
            $totalBarangayMedicines = BarangayMedicine::where('barangay_id', $barangayId)->count();
            $totalBarangayPatients = BarangayPatient::where('barangay_id', $barangayId)->count();

            $totalBarangayDistributions = BarangayDistribution::where('barangay_id', $barangayId)->count();
            $totalDistributionAddedToday = BarangayDistribution::where('barangay_id', $barangayId)
                ->whereDate('created_at', today())
                ->count();
            // Count out of stock, nearly out of stock, expired, and nearly expired medicines
            $totalOutOfStockMedicines = BarangayMedicine::where('barangay_id', $barangayId)
                ->where('stocks', 0)
                ->count();

            $totalExpiredMedicines = BarangayMedicine::where('barangay_id', $barangayId)
                ->where('expiration_date', '<', now())
                ->count();

            $totalNearlyOutOfStockMedicines = BarangayMedicine::where('barangay_id', $barangayId)
                ->where('stocks', '>', 1)
                ->where('stocks', '<=', 50)
                ->count();

            $totalNearlyExpiredMedicines = BarangayMedicine::where('barangay_id', $barangayId)
                ->where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->count();
            $totalPatientsAddedToday = BarangayPatient::where('barangay_id', $barangayId)
                ->whereDate('created_at', today())
                ->count();
            $distributionSchedulesInYourBarangay = Schedule::with(['barangay', 'medicine'])
                ->where('barangay_id', $user->barangay->id)
                ->whereBetween('schedule_date_time', [now()->startOfWeek(), now()->endOfWeek()])
                ->get();
            $nearlyOutOfStockMedicines = BarangayMedicine::where('barangay_id', $user->barangay->id)
                ->where('stocks', '>', 1)
                ->where('stocks', '<=', 50)
                ->get();
            $nearlyExpiredMedicines = BarangayMedicine::where('barangay_id', $user->barangay->id)
                ->where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->get();
            return view('home', compact(
                'totalBarangayMedicines',
                'totalBarangayPatients',
                'totalPatientsAddedToday',
                'totalBarangayDistributions',
                'totalOutOfStockMedicines',
                'totalExpiredMedicines',
                'totalNearlyOutOfStockMedicines',
                'totalNearlyExpiredMedicines',
                'totalDistributionAddedToday',
                'distributionSchedulesInYourBarangay',
                'nearlyOutOfStockMedicines',
                'nearlyExpiredMedicines',
            ));
        } elseif ($user->isPharmacist()) {
            // Pharmacist Dashboard logic
            $totalMedicines = Medicine::count();
            $totalPatients = Patient::count();
            $totalPatientsAddedToday = Patient::whereDate('created_at', today())->count();
            $totalBarangay = Barangay::count();
            $totalDistributionBarangay = DistributionBarangay::count();
            $totalPatientDistributions = Distribution::count();
            $totalOutOfStockMedicines = Medicine::where('stocks', 0)->count();
            $totalExpiredMedicines = Medicine::where('expiration_date', '<', now())->count();
            $totalNearlyOutOfStockMedicines = Medicine::where('stocks', '>', 1)
                ->where('stocks', '<=', 50)
                ->count();
            $totalNearlyExpiredMedicines = Medicine::where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->count();
            $totalPatientDistributionAddedToday = Distribution::whereDate('created_at', today())->count();
            $totalBarangayDistributionAddedToday = DistributionBarangay::whereDate('created_at', today())->count();
            $distributionSchedulesToday = Schedule::with(['barangay', 'medicine'])
                ->whereDate('schedule_date_time', today())
                ->get();
            $distributionSchedulesThisWeek = Schedule::with(['barangay', 'medicine'])
                ->whereBetween('schedule_date_time', [now()->startOfWeek(), now()->endOfWeek()])
                ->get();
            $nearlyOutOfStockMedicines = Medicine::where('stocks', '>', 1)
                ->where('stocks', '<=', 50)
                ->get(); // Fetch all nearly out of stock medicines

            $nearlyExpiredMedicines = Medicine::where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->get();
            return view('home', compact(
                'totalMedicines',
                'totalPatients',
                'totalPatientsAddedToday',
                'totalBarangay',
                'totalDistributionBarangay',
                'totalPatientDistributions',
                'totalOutOfStockMedicines',
                'totalExpiredMedicines',
                'totalNearlyOutOfStockMedicines',
                'totalNearlyExpiredMedicines',
                'totalPatientDistributionAddedToday',
                'totalBarangayDistributionAddedToday',
                'distributionSchedulesToday',
                'distributionSchedulesThisWeek',
                'nearlyOutOfStockMedicines',
                'nearlyExpiredMedicines',
            ));
        } else {
            return view('home');
        }
    }
}
