<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayDistribution extends Model
{
    use HasFactory;
    protected $table = 'barangay_distributions';

    protected $fillable = [
        'barangay_patient_id',
        'barangay_medicine_id',
        'stocks',
        'checkup_date',
        'diagnose',
    ];


    public function patient()
    {
        return $this->belongsTo(BarangayPatient::class, 'barangay_patient_id');
    }

    public function medicine()
    {
        return $this->belongsTo(BarangayMedicine::class, 'barangay_medicine_id');
    }
}
