<?php
declare(strict_types=1);

namespace App\L_18_02_24\src\core\Validation;

class Validator
{
    public const RULE_REQUIRED = 'required';
    public const RULE_NUMBER = 'number';

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

                if ($ruleName === self::RULE_NUMBER && !\preg_match('/^[0-9]+$/', (string)$value)) {
                    $this->addError($attribute, self::RULE_NUMBER);
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

        $this->errors[$attribute] = $message;
    }

    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_NUMBER => 'There should only be numbers here',
        ];
    }

}
