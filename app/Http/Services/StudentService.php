<?php

namespace App\Http\Services;

use App\Http\Services\BaseService as Base;
use App\Models\Student;

class StudentService extends Base
{
    public $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }
}
