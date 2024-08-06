<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Cantique;
use App\Models\Confirme;
use App\Models\Charge;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> 
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'telephone',
        'facebook',
        'youtube',
        'avatar',
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public $full_name;
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

    public function cantiques()
    {
        return $this->hasMany(Cantique::class);
    }

    public function confirmes()
    {
        return $this->hasMany(Confirme::class);
    }

    public function charges()
    {
        return $this->belongsToMany(Charge::class, 'charge_users')
        ->withPivot(['assemblee_id', 'pays_id', 'position_chantre', 'principal'])
        ->orderByPivot('created_at', 'desc');
    }
}
