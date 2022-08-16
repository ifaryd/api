<?php

namespace App\Models;

use App\Models\Langue;
use App\Models\Verset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Predication extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function versets()
    {
        return $this->hasMany(Verset::class);
    }
}
