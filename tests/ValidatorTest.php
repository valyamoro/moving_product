<?php
declare(strict_types=1);

use App\L_18_02_24\core\Validation\Validator;
use App\L_18_02_24\Models\ProductModel;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidateProduct(): void
    {
        $formProductWareHouse = new \App\Models\FormProductWareHouseModel(
            1,
            ['from' => 5, 'to' => 6],
            5,
        );

        $formProductWareHouse->validator->setRules($formProductWareHouse->rules(require __DIR__ . '/../config/test_db.php'));
        $formProductWareHouse->validator->validate($formProductWareHouse);

        $result = $formProductWareHouse->validator->errors;
        $this->assertEmpty($result);
    }

}
