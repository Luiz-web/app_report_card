<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['id_school_year', 'id_professional_focus', 'name', 'age', 'first_score', 'second_score'];

    public function schoolYear() {
        return $this->belongsTo('App\Models\SchoolYear', 'id_school_year');
    }

    public function professionalFocus() {
        return $this->belongsTo('App\Models\ProfessionalFocus', 'id_professional_focus');
    }
}
