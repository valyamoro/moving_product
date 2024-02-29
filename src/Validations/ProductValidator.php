<?php
declare(strict_types=1);

namespace App\Validations;

use App\core\Validator;
use App\Models\Product;
use App\Models\Storage;

class ProductValidator extends Validator
{
    public const RULE_MIN_QUANTITY = 'min';
    public const RULE_MAX_QUANTITY = 'max';
    public const RULE_STORAGES_MATCH = 'storages_match';
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

        if ($ruleName === self::RULE_MIN_QUANTITY && \is_numeric($this->getMoveQuantity()) && $this->getMoveQuantity() < $rule['min_quantity']) {
            $this->addError(self::RULE_MIN_QUANTITY, $rule);
        }

        if ($ruleName === self::RULE_MAX_QUANTITY && \is_numeric($this->getMoveQuantity()) && $this->getMoveQuantity() > $rule['max_quantity']) {
            $this->addError(self::RULE_MAX_QUANTITY, $rule);
        }

        if ($ruleName === self::RULE_STORAGES_MATCH && $rule['is_match']) {
            $this->addError(self::RULE_STORAGES_MATCH);
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
                [self::RULE_MIN_QUANTITY, 'min_quantity' => '1'],
                [self::RULE_MAX_QUANTITY, 'max_quantity' => $this->getPastQuantityFromStorage()],
            ],

            'storagesId' => [
                [
                    self::RULE_STORAGES_MATCH,
                    'is_match' => $this->getStoragesId()['from'] === $this->getStoragesId()['to']
                ],
            ],

        ];
    }
}
