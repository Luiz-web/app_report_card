<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Situation extends Model
{

    use HasFactory;
    protected $fillable = ['student_id', 'total_score', 'status', 'name'];

    //finding the student through the student_id inserted on request
    public function findStudent($request) {
        $student_id = $request->student_id;
        $student = Student::find($student_id);
        return $student;
    }

    public static function settingName($student) {
        $name = $student->name;
        return $name;
    }
    
    public static function settingTotalScore($student) {
        $first_score = $student->first_score;
        $second_score = $student->second_score;
        $total_score = $first_score + $second_score;

        return $total_score;
    }

    public static function settingStatus($total_score) {
        $status = 'R';

        if($total_score >= 60) {
            $status = 'A';
        }

        return $status;
    }

    public function rules() {
        return [
            'student_id' => 'required|unique:situations,student_id,'.$this->id.'|integer',
        ];
    }
    
    public function students() {
        return $this->belongsTo('App\Models\Student','student_id');
    }
}
