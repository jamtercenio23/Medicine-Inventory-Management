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
