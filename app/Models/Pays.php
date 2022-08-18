<?php

namespace App\Models;

use App\Models\Ville;
use App\Models\Confirme;
use App\Models\Langue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pays extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'sigle',
    ];

    public function villes()
    {
        return $this->hasMany(Ville::class);
    }

    public function confirmes()
    {
        return $this->hasMany(Confirme::class);
    }

    /**
     * Get all of the deployments for the project.
     */
    public function assemblees()
    {
        return $this->hasManyThrough(Assemblee::class, Ville::class);
    }

    public function langues(){
        return $this->belongsToMany(Langue::class)->withPivot('principal');
    }
}
