<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Situation;

class Approved extends Model
{
    use HasFactory;
    protected $table = 'approved';
    protected $fillable = ['situation_id', 'name', 'school_year', 'professional_area'];

    //  retrieving the id of the situations where the students were approved
    public static function retrievingSituations() {
        $situations_id = [];
        $situations = Situation::where('status', 'A')->orderBy('id')->get();
        foreach($situations as $situation) {
            $situations_id[] = $situation->id;
        }

        return $situations_id;
    }
    //retrieving the situation_id of the students that are already on approved table
    public static function retrievingApproveds() {
        $approved_id = [];
        $approveds = Approved::all();
        foreach($approveds as $approved) {
            $approved_id[] = $approved->situation_id;
        } 

        return $approved_id;
    }

    public static function gettingnewRegisters() {
        $situations_id =Approved::retrievingSituations();
        $approved_id = Approved::retrievingApproveds();

        $new_registers = [];
        //putting in a array the differencea between the two arrays with the situation_id 
        $difference = array_diff($situations_id, $approved_id);    
        
        //Retrieving the situations again, but putting in an array(new_registers) the ids that are in the difference array, that is, the ids of situation that are not in the approved yet.
        $situations = Situation::with('students')->whereIn('id', $difference)->get();
        foreach($situations as $situation) {
            $new_registers[] = $situation;
        }

         return $new_registers;
    }

    public function situations() {
        return $this->hasMany('App\Models\Situation');
    }
}
