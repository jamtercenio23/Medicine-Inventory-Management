<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barangay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name',];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
    public function distributions()
    {
        return $this->hasMany(DistributionBarangay::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function barangayPatients()
    {
        return $this->hasMany(BarangayPatient::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function barangayDistributions()
    {
        return $this->hasMany(BarangayDistribution::class);
    }
    public function barangayMedicines()
    {
        return $this->hasMany(BarangayMedicine::class, 'barangay_id');
    }
}
