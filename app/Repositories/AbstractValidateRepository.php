<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


abstract class AbstractValidateRepository {

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function validateData(Request $request, $mrules) {
        if($request->method() === 'PATCH') {
            $dinamicRules = array();

            foreach($mrules as $input => $rule) {

                if(array_key_exists($input, $request->all())) {
                    $dinamicRules[$input] = $rule;
                }
            }

            return $request->validate($dinamicRules);
        
        } else {
            return $request->validate($mrules);
        }
    }

}

?>