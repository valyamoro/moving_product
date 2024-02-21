<?php
declare(strict_types=1);

namespace App\core;

use App\core\Validation\Validator;

abstract class Model
{
    public Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

}
