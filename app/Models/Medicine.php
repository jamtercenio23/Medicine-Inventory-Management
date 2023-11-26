<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'generic_name', 'brand_name', 'category_id', 'price', 'stocks', 'expiration_date', 'created_by', 'updated_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function distributions()
    {
        return $this->hasMany(Distribution::class, 'medicine_id');
    }
}
