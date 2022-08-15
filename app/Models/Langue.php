<?php

namespace App\Models;

use App\Models\Photo;
use App\Models\Video;
use App\Models\Cantique;
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

    public function predication()
    {
        return $this->hasMany(Predication::class);
    }

    public function cantique()
    {
        return $this->hasMany(Cantique::class);
    }

    public function video()
    {
        return $this->hasMany(Video::class);
    }

    public function photo()
    {
        return $this->hasMany(Photo::class);
    }

    public function temoignage()
    {
        return $this->hasMany(Temoignage::class);
    }

    public function actualite()
    {
        return $this->hasMany(Actualite::class);
    }
}
