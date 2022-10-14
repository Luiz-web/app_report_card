<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approved extends Model
{
    use HasFactory;
    protected $table = 'approved';
    protected $fillable = ['situation_id', 'name', 'school_year', 'professional_area'];

    public function situations() {
        return $this->hasMany('App\Models\Situation');
    }
}
