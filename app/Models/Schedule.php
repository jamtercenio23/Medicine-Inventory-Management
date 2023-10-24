<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['barangay_id', 'medicine_id', 'stock', 'schedule_date_time'];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
