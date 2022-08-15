<?php

namespace App\Models;

use App\Models\User;
use App\Models\Langue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cantique extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
