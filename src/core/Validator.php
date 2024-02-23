<?php
declare(strict_types=1);

namespace App\core;

abstract class Validator
{
    public const RULE_REQUIRED = 'required';
    protected array $errors = [];

    abstract public function validate(): bool;

    protected function addError(string $rule, array $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';

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
            static::RULE_QUANTITY_MIN => 'Минимальное количество товаров {min_quantity}',
            static::RULE_QUANTITY_MAX => 'Максимальное количество товаров которое вы можете переместить с этого склада {max_quantity}',
            static::RULE_STORAGE_MATCH => 'Вы не можете переместить этот товар на этот же склад',
            static::RULE_NUMBERS => 'В этом поле должны быть только цифры!',
        ];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}
