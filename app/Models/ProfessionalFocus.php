<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalFocus extends Model
{
    use HasFactory;
    protected $table = 'professional_focus'; // Appropriately renaming the table
    protected $fillable = ['professional_area'];

    public function rules() {
        return [
            'professional_area' => 'required|unique:professional_focus,professional_area,'.$this->id.'min:2|max:30',
        ];
    }

    public function students() {
        return $this->hasMany('App\Models\Student');
    }
}
