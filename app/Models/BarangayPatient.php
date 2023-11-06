<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayPatient extends Model
{
    use HasFactory;

    protected $table = 'barangay_patients';

    protected $fillable = [
        'barangay_id',
        'first_name',
        'last_name',
        'birthdate',
        'age',
        'gender',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}
