<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangayDistribution extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'barangay_distributions';

    protected $fillable = [
        'barangay_id',
        'bhw_id',
        'barangay_patient_id',
        'barangay_medicine_id',
        'stocks',
        'checkup_date',
        'diagnose',
    ];

    public function barangayPatient()
    {
        return $this->belongsTo(BarangayPatient::class, 'barangay_patient_id');
    }

    public function barangayMedicine()
    {
        return $this->belongsTo(BarangayMedicine::class, 'barangay_medicine_id');
    }
    public function bhw()
    {
        return $this->belongsTo(User::class, 'bhw_id');
    }
}
