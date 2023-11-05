<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'birthdate', 'age', 'gender', 'barangay_id',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
    public function distributions()
{
    return $this->hasMany(Distribution::class);
}
}
