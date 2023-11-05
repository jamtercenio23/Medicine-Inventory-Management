<?php

namespace App\Http\Controllers\barangay;

use App\Http\Controllers\Controller;
use App\Models\DistributionBarangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangayMedicinesController extends Controller
{
    public function index(Request $request)
    {
        return view('barangay.barangay_medicines.index');
    }
}
