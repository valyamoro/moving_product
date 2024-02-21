<?php
declare(strict_types=1);

use App\L_18_02_24\core\Validation\Validator;
use App\L_18_02_24\Models\ProductModel;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidateProduct(): void
    {
        $data = [
            'id' => 1,
            'idWareHouse' => 1,
            'title' => 'product 1',
            'price' => 500,
            'quantity' => 3,
        ];

        $model = new ProductModel(...$data);
        $validator = new Validator();
        $validator->setRules($model->rules());

        $this->assertTrue($validator->validate($model));
    }

}
