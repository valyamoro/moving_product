<?php
declare(strict_types=1);

namespace App\core\Validation;

use App\core\Model;

class Validator
{
    public const RULE_REQUIRED = 'required';
    public const RULE_QUANTITY_MIN = 'min_quantity';
    public const RULE_QUANTITY_MAX = 'max_quantity';
    public const RULE_WAREHOUSES_MATCH = 'warehouses_match';


    private array $rules;
    public array $errors = [];

    public function setRules($value): void
    {
        $this->rules = $value;
    }

    public function validate(Model $model): bool
    {
        foreach ($this->rules as $attribute => $rules) {
            $getAttribute = 'get' . $attribute;
            $value = $model->$getAttribute();
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (\is_array($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && empty($value)) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_QUANTITY_MIN && $value < $rule['min_quantity']) {
                    $this->addError($attribute, self::RULE_QUANTITY_MIN, $rule);
                }


                if ($ruleName === self::RULE_QUANTITY_MAX && $value > $rule['max_quantity']) {
                    $this->addError($attribute, self::RULE_QUANTITY_MAX, $rule);
                }

                if ($ruleName === self::RULE_WAREHOUSES_MATCH && $model->getWareHousesId()['from'] === $model->getWareHousesId()['to']) {
                    $this->addError($attribute, self::RULE_WAREHOUSES_MATCH);
                }
            }
        }

        return empty($this->errors);
    }

    private function addError(string $attribute, string $rule, array $params = [], string $message = ''): void
    {
        if (empty($message)) {
            $message = $this->errorMessages()[$rule] ?? '';
        }

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $message = \str_replace("{{$key}}", (string)$value, $message);
            }
        }

        $this->errors[] = $message;
    }

    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Вы должны указать количество товаров',
            self::RULE_QUANTITY_MIN => 'Минимальное количество товаров - {min_quantity}',
            self::RULE_QUANTITY_MAX => 'Максимальное количество товаров которое вы можете переместить с этого склада - {max_quantity}',
            self::RULE_WAREHOUSES_MATCH => 'Вы не можете переместить этот товар на этот же склад',
        ];
    }

}
