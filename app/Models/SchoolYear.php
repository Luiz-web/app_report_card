<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;
    protected $fillable = ['school_year'];

    public function rules() {
        return [
            'school_year' => 'required|unique:school_years,school_year,'.$this->id.'|min:5|max:30',
        ];
    }

    public function students() {
        return $this->hasMany('App\Models\Student', 'school_year_id');
    }

    
}
