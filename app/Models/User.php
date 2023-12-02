<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'barangay_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];


    static public function getEmailSingle($email){

        return self::where('email',$email)->first();

    }

    static public function getTokenSingle($token)
    {
        return self::where('remember_token',$token)->first();


    }

    public function isSuperAdmin()
    {
        return $this->hasRole('superadmin');
    }
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
    public function isPharmacist()
    {
        return $this->hasRole('pharmacist');
    }
    public function isBarangayUser()
    {
        return $this->hasRole('barangay');
    }
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id')->withDefault();
    }
    public function isBHW()
    {
        return $this->hasRole('bhw');
    }
    protected $attributes = [
        'is_active' => true,
    ];
    public function createdCategories()
    {
        return $this->hasMany(Category::class, 'created_by');
    }
    public function updatedCategories()
    {
        return $this->hasMany(Category::class, 'updated_by');
    }
    public function createdMedicines()
    {
        return $this->hasMany(Medicine::class, 'created_by');
    }
    public function updatedMedicines()
    {
        return $this->hasMany(Medicine::class, 'updated_by');
    }
    public function createdPatients()
    {
        return $this->hasMany(Patient::class, 'created_by');
    }
    public function updatedPatients()
    {
        return $this->hasMany(Patient::class, 'updated_by');
    }
}
