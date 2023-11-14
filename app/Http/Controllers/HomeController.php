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
            $totalBarangay = Barangay::count();
            $totalDistributionBarangay = DistributionBarangay::count();
            $totalPatientDistributions = Distribution::count();
            $totalOutOfStockMedicines = Medicine::where('stocks', 0)->count();
            $totalExpiredMedicines = Medicine::where('expiration_date', '<', now())->count();

            return view('home', compact(
                'totalMedicines',
                'totalPatients',
                'totalBarangay',
                'totalDistributionBarangay',
                'totalPatientDistributions',
                'totalOutOfStockMedicines',
                'totalExpiredMedicines'
            ));
        } elseif ($user->isBHW()) {
            // BHW Dashboard
            $barangayId = $user->barangay->id;

            $totalBarangayMedicines = BarangayMedicine::where('barangay_id', $barangayId)->count();
            $totalBarangayPatients = BarangayPatient::where('barangay_id', $barangayId)->count();
            $totalBarangayDistributions = BarangayDistribution::where('barangay_id', $barangayId)->count();

            return view('home', compact(
                'totalBarangayMedicines',
                'totalBarangayPatients',
                'totalBarangayDistributions'
            ));
        } elseif ($user->isPharmacist()) {
            // Pharmacist Dashboard logic
            $totalMedicines = Medicine::count();
            $totalPatients = Patient::count();
            $totalBarangay = Barangay::count();
            $totalDistributionBarangay = DistributionBarangay::count();
            $totalPatientDistributions = Distribution::count();
            $totalOutOfStockMedicines = Medicine::where('stocks', 0)->count();
            $totalExpiredMedicines = Medicine::where('expiration_date', '<', now())->count();

            return view('home', compact(
                'totalMedicines',
                'totalPatients',
                'totalBarangay',
                'totalDistributionBarangay',
                'totalPatientDistributions',
                'totalOutOfStockMedicines',
                'totalExpiredMedicines'
            ));
        } else {
            // Default logic for other user roles
            return view('home'); // Adjust the default view as needed
        }
    }
}
