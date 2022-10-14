<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['school_year_id', 'professional_focus_id', 'name', 'age', 'first_score', 'second_score'];

    public function rules() {
        return [
            'school_year_id' => 'required|exists:school_years,id',
            'professional_focus_id' => 'required|exists:professional_focus,id',
            'name' => 'required|unique:students,name,'.$this->id.'|min:3',
            'age' => 'required|integer|min:12|max:20',
            'first_score' => 'required|numeric',
            'second_score' => 'required|numeric',
        ];
}

    public function schoolYear() {
        return $this->belongsTo('App\Models\SchoolYear');
    }

    public function professionalFocus() {
        return $this->belongsTo('App\Models\ProfessionalFocus');
    }

    public function situation() {
        return $this->belongsTo('App\Models\Situation','student_id');
    }
}
