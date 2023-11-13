<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'first_name', 'last_name', 'birthdate', 'age', 'gender', 'barangay_id',
        'blood_pressure', 'heart_rate', 'weight', 'height',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
    public function distributions()
    {
        return $this->hasMany(Distribution::class);
    }
    public function getBloodPressureStatus()
    {
        $bloodPressure = $this->blood_pressure;
        if ($bloodPressure < 120) {
            return 'Normal';
        } elseif ($bloodPressure >= 120 && $bloodPressure <= 139) {
            return 'Elevated';
        } elseif ($bloodPressure >= 140 && $bloodPressure <= 159) {
            return 'High Blood Pressure (Stage 1)';
        } elseif ($bloodPressure >= 160) {
            return 'High Blood Pressure (Stage 2)';
        } else {
            return 'Not Available';
        }
    }

    public function getHeartRateStatus()
    {
        $heartRate = $this->heart_rate;
        if ($heartRate >= 60 && $heartRate <= 100) {
            return 'Normal';
        } elseif ($heartRate < 60) {
            return 'Too Low';
        } elseif ($heartRate > 100) {
            return 'Too High';
        } else {
            return 'Not Available';
        }
    }
}
