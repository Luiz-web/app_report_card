<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalFocus extends Model
{
    use HasFactory;
    protected $table = 'professional_focus';
    protected $fillable = ['professional_area'];
}
