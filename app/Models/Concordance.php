<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Concordance extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function verset_from(){
        return $this->belongsTo(Verset::class, 'verset_from_id', 'id');
    }

    public function verset_to(){
        return $this->belongsTo(Verset::class, 'verset_to_id', 'id');
    }
}
