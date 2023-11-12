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
        // Fetch total counts
        $totalMedicines = Medicine::count();
        $totalPatients = Patient::count();
        $totalBarangay = Barangay::count();
        $totalDistributionBarangay = DistributionBarangay::count();
        $totalPatientDistributions = Distribution::count();
        $totalOutOfStockMedicines = Medicine::where('stocks', 0)->count();
        $totalExpiredMedicines = Medicine::where('expiration_date', '<', now())->count();
        $totalBarangayMedicines = BarangayMedicine::count();
        $totalBarangayPatients = Patient::count();
        $totalBarangayDistributions = BarangayDistribution::count();
        // Pass counts to the view
        return view('home', compact('totalMedicines', 'totalPatients', 'totalBarangay', 'totalDistributionBarangay', 'totalPatientDistributions', 'totalOutOfStockMedicines', 'totalExpiredMedicines', 'totalBarangayMedicines', 'totalBarangayPatients', 'totalBarangayDistributions'));
    }
}
