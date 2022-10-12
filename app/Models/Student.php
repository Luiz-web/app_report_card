<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['school_year_id', 'professional_focus_id', 'name', 'age', 'first_score', 'second_score'];

    public function schoolYear() {
        return $this->belongsTo('App\Models\SchoolYear', 'school_year_id');
    }

    public function professionalFocus() {
        return $this->belongsTo('App\Models\ProfessionalFocus', 'professional_focus_id');
    }

    public function situation() {
        return $this->belongsTo('App\Models\Situation', 'student_id');
    }
}
