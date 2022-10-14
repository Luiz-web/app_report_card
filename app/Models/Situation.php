<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Situation extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'total_score', 'status', 'name'];

    public function rules() {
        return [
            'student_id' => 'required|unique:situations,student_id,'.$this->id.'|integer',
        ];
    }
    
    public function students() {
        return $this->belongsTo('App\Models\Student','student_id');
    }
}
