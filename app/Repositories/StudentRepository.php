<?php 

namespace App\Repositories;

class StudentRepository extends AbstractRepository{
    public function selectProAreaAttributes($area_attrs) {
        $this->model = $this->model->with($area_attrs);
    }
}

?>