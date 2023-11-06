<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

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
    public function barangaypatients()
{
    return $this->hasMany(BarangayPatient::class);
}
}
