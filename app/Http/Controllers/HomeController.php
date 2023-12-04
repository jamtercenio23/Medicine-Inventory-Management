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
use App\Models\User;
use Charts;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\Classes\Chart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

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
            $totalNearlyOutOfStockMedicines = Medicine::where('stocks', '>', 0)
                ->where('stocks', '<=', 50)
                ->count();
            $totalNearlyExpiredMedicines = Medicine::where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->count();
            $totalPatientDistributionAddedToday = Distribution::whereDate('created_at', today())->count();
            $totalBarangayDistributionAddedToday = DistributionBarangay::whereDate('created_at', today())->count();
            $distributionSchedulesToday = Schedule::with(['barangay', 'medicine'])
                ->whereDate('schedule_date_time', today())
                ->paginate(2, ['*'], 'today_page');

            $distributionSchedulesThisWeek = Schedule::with(['barangay', 'medicine'])
                ->whereBetween('schedule_date_time', [now()->startOfWeek(), now()->endOfWeek(),])
                ->paginate(2, ['*'], 'this_week_page');
            $nearlyOutOfStockMedicines = Medicine::where('stocks', '>', 0)
                ->where('stocks', '<=', 50)
                ->paginate(2, ['*'], 'out_of_stock_page');
            $nearlyExpiredMedicines = Medicine::where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->paginate(2, ['*'], 'expired_page');
            $newlyAddedMedicines = Medicine::where('created_at', '>', now()->subHours(12))->get();
            $totalUsers = User::count();
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
                'newlyAddedMedicines',
                'totalUsers',

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
            $totalBarangayOutOfStockMedicines = BarangayMedicine::where('barangay_id', $barangayId)
                ->where('stocks', 0)
                ->count();

            $totalBarangayExpiredMedicines = BarangayMedicine::where('barangay_id', $barangayId)
                ->where('expiration_date', '<', now())
                ->count();

            $totalNearlyBarangayOutOfStockMedicines = BarangayMedicine::where('barangay_id', $barangayId)
                ->where('stocks', '>', 0)
                ->where('stocks', '<=', 50)
                ->count();

            $totalNearlyBarangayExpiredMedicines = BarangayMedicine::where('barangay_id', $barangayId)
                ->where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->count();
            $totalPatientsAddedToday = BarangayPatient::where('barangay_id', $barangayId)
                ->whereDate('created_at', today())
                ->count();
            $distributionSchedulesInYourBarangay = Schedule::with(['barangay', 'medicine'])
                ->where('barangay_id', $user->barangay->id)
                ->whereBetween('schedule_date_time', [now()->startOfWeek(), now()->endOfWeek()])
                ->paginate(2, ['*'], 'this_week_page');
            $nearlyBarangayOutOfStockMedicines = BarangayMedicine::where('barangay_id', $user->barangay->id)
                ->where('stocks', '>', 0)
                ->where('stocks', '<=', 50)
                ->paginate(2, ['*'], 'out_of_stock_page');
            $nearlyBarangayExpiredMedicines = BarangayMedicine::where('barangay_id', $user->barangay->id)
                ->where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->paginate(2, ['*'], 'expired_page');
            $newlyAddedBarangayMedicines = BarangayMedicine::where('barangay_id', $barangayId)
                ->where('created_at', '>', now()->subHours(12))
                ->with('medicine.category') // Assuming there is a relationship between BarangayMedicine and Medicine
                ->paginate(2, ['*'], 'newly_page');
            return view('home', compact(
                'totalBarangayMedicines',
                'totalBarangayPatients',
                'totalPatientsAddedToday',
                'totalBarangayDistributions',
                'totalBarangayOutOfStockMedicines',
                'totalBarangayExpiredMedicines',
                'totalNearlyBarangayOutOfStockMedicines',
                'totalNearlyBarangayExpiredMedicines',
                'totalDistributionAddedToday',
                'distributionSchedulesInYourBarangay',
                'nearlyBarangayOutOfStockMedicines',
                'nearlyBarangayExpiredMedicines',
                'newlyAddedBarangayMedicines'
            ));
        } elseif ($user->isSuperAdmin()) {
            $totalUsers = User::count();
            return view('home', compact(
                'totalUsers',
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
                ->paginate(2, ['*'], 'today_page');

            $distributionSchedulesThisWeek = Schedule::with(['barangay', 'medicine'])
                ->whereBetween('schedule_date_time', [now()->startOfWeek(), now()->endOfWeek(),])
                ->paginate(2, ['*'], 'this_week_page');
            $nearlyOutOfStockMedicines = Medicine::where('stocks', '>', 0)
                ->where('stocks', '<=', 50)
                ->paginate(2, ['*'], 'out_of_stock_page');
            $nearlyExpiredMedicines = Medicine::where('expiration_date', '>', now())
                ->where('expiration_date', '<=', now()->addDays(10))
                ->paginate(2, ['*'], 'expired_page');
            $newlyAddedMedicines = Medicine::where('created_at', '>', now()->subHours(12))->get();
            $totalUsers = User::count();
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
                'newlyAddedMedicines',
                'totalUsers',
            ));
        } else {
            return view('home');
        }
    }
}
