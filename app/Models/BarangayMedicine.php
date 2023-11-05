<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayMedicine extends Model
{
    use HasFactory;

    protected $fillable = ['barangay_id', 'medicine_id', 'stocks', 'price', 'expiration_date'];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    public function distributions()
    {
        return $this->hasMany(DistributionBarangay::class);
    }
}
