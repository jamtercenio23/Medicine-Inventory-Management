<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'generic_name', 'brand_name', 'category_id', 'price', 'stocks', 'expiration_date'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
