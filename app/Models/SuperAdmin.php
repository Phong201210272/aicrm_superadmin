<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SuperAdmin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'super_admins';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'bank_id',
        'bank_account',
<<<<<<< HEAD
        'company_bank_id',
        'company_bank_account',
        'company_name',
        'banner',
=======
        'bank_company_id',
        'bank_company_account'

>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

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
    ];
}
