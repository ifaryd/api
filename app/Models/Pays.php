<?php

namespace App\Models;

use App\Models\Ville;
use App\Models\Confirme;
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

    public function ville()
    {
        return $this->hasMany(Ville::class);
    }

    public function confirme()
    {
        return $this->hasMany(Confirme::class);
    }
}
