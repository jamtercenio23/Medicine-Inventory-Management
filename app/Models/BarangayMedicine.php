<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangayMedicine extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'barangay_medicines';

    protected $fillable = [
        'barangay_id',
        'medicine_id',
        'generic_name',
        'brand_name',
        'category',
        'price',
        'expiration_date',
        'stocks',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
    public function distribution_barangay()
    {
        return $this->belongsTo(DistributionBarangay::class, 'distribution_barangay');
    }
}
