<?php

namespace App\Models;

use App\Models\Pays;
use App\Models\Assemblee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ville extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function pays()
    {
        return $this->belongsTo(Pays::class, 'pays_id', 'id');
    }

    public function assemblees()
    {
        return $this->hasMany(Assemblee::class);
    }
}
