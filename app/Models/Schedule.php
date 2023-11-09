<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;
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
