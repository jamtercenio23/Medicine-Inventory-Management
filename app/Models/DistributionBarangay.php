<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionBarangay extends Model
{
    use HasFactory;

    protected $fillable = ['barangay_id', 'medicine_id', 'stocks', 'distribution_date'];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

}
