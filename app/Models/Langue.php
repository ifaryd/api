<?php

namespace App\Models;

use App\Models\Photo;
use App\Models\Video;
use App\Models\Cantique;
use App\Models\Pays;
use App\Models\Actualite;
use App\Models\Temoignage;
use App\Models\Predication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Langue extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function predications()
    {
        return $this->hasMany(Predication::class);
    }

    public function cantiques()
    {
        return $this->hasMany(Cantique::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function temoignages()
    {
        return $this->hasMany(Temoignage::class);
    }

    public function actualites()
    {
        return $this->hasMany(Actualite::class);
    }

    public function pays(){
        return $this->belongsToMany(Pays::class);
    }
}
