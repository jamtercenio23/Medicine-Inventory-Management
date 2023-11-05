<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayMedicine extends Model
{
    use HasFactory;

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

    // Define relationships with the Barangay and Medicine models
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
}
