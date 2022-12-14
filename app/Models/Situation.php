<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Situation extends Model
{

    use HasFactory;
    protected $fillable = ['student_id', 'total_score', 'status', 'name'];

    public static function retrievingStudents() {
        $students_id = [];
        $students = Student::with('situation')->get();
        foreach($students as $student) {
            $students_id[] = $student->id;
        }

        return $students_id;
    }

    public static function retrievingSituations() {
        $array_situations = [];
        $situations = Situation::with('students')->get();
        foreach($situations as $situation) {
            $array_situations[] = $situation->student_id;
        }

        return $array_situations;
    }

    public function gettingNewStudents() {
        $students_id = Situation::retrievingStudents();
        $array_situations = Situation::retrievingSituations();

        $difference = array_diff($students_id, $array_situations);

        $new_students = [];
        $students = Student::with('situation')->whereIn('id', $difference)->get();
        foreach($students as $student) {
            $new_students[] = $student;
        }

        return $new_students;
    } 

    //finding the student through the student_id inserted on request
    public static function findStudentId($student) {
        $student_id = $student->id;
        $student = Student::find($student_id);
        $student_id = $student->id;
        return $student_id;
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
            'student_id' => 'unique:situations,student_id,'.$this->id.'|integer',
        ];
    }
    
    public function students() {
        return $this->belongsTo('App\Models\Student','student_id');
    }
}
