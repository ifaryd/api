<?php

namespace App\Models;

use App\Models\Type;
use App\Models\Langue;
use App\Models\Confirme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
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

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function confirme()
    {
        return $this->hasOne(Confirme::class);
    }
}
