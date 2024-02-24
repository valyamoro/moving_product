<?php

namespace App\Validations;

use App\core\Validator;
use App\Models\Product;
use App\Models\Storage;

class ProductValidator extends Validator
{
    public const RULE_QUANTITY_MIN = 'min_quantity';
    public const RULE_QUANTITY_MAX = 'max_quantity';
    public const RULE_STORAGE_MATCH = 'storages_match';
    public const RULE_NUMBERS = 'numbers';

    public function __construct(
        private readonly int|string $moveQuantity,
        private readonly int $pastQuantityFromStorage,
        private readonly array $storagesId,
    ) {
    }

    public function getMoveQuantity(): int|string
    {
        return $this->moveQuantity;
    }

    public function getPastQuantityFromStorage(): int
    {
        return $this->pastQuantityFromStorage;
    }

    public function getStoragesId(): array
    {
        return $this->storagesId;
    }

    protected function checkRules(string $ruleName, string|array $rule): void
    {
        if ($ruleName === self::RULE_REQUIRED && empty($this->getMoveQuantity())) {
            $this->addError(self::RULE_REQUIRED);
        }

        if ($ruleName === self::RULE_QUANTITY_MIN && \is_numeric($this->getMoveQuantity()) && $this->getMoveQuantity() < $rule['min_quantity']) {
            $this->addError(self::RULE_QUANTITY_MIN, $rule);
        }

        if ($ruleName === self::RULE_QUANTITY_MAX && \is_numeric($this->getMoveQuantity()) && $this->getMoveQuantity() > $rule['max_quantity']) {
            $this->addError(self::RULE_QUANTITY_MAX, $rule);
        }

        if ($ruleName === self::RULE_STORAGE_MATCH && $rule['is_match']) {
            $this->addError(self::RULE_STORAGE_MATCH);
        }

        if ($ruleName === self::RULE_NUMBERS && !empty($this->getMoveQuantity()) && !\preg_match('/^\d+$/',
                (string)$this->getMoveQuantity())) {
            $this->addError(self::RULE_NUMBERS);
        }
    }

    protected function rules(): array
    {
        return [
            'moveQuantity' => [
                self::RULE_REQUIRED,
                self::RULE_NUMBERS,
                [self::RULE_QUANTITY_MIN, 'min_quantity' => '1'],
                [self::RULE_QUANTITY_MAX, 'max_quantity' => $this->getPastQuantityFromStorage()],
            ],

            'storagesId' => [
                [
                    self::RULE_STORAGE_MATCH,
                    'is_match' => $this->getStoragesId()['from'] === $this->getStoragesId()['to']
                ],
            ],

        ];
    }
}
