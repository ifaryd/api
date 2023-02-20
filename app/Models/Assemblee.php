<?php

namespace App\Models;

use App\Models\Ville;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
class Assemblee extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function userss()
    {
        return $this->belongsToMany(User::class)->withPivot(['assemblee_id', 'pays_id', 'position_chantre', 'principal']);
    }

}
 