<?php

declare(strict_types=1);

namespace App\Validation;

final class ValidationResult
{
    /**
     * @param array<string, string> $errors  champ => message d'erreur
     * @param array<string, mixed> $data     données acceptées (nettoyées)
     */
    private function __construct(
        private readonly bool $valid,
        private readonly array $errors,
        private readonly array $data,
    ) {
    }

    public static function success(array $data): self
    {
        return new self(true, [], $data);
    }

    public static function failure(array $errors): self
    {
        return new self(false, $errors, []);
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return array<string, string>
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @return array<string, mixed>
     */
    public function data(): array
    {
        return $this->data;
    }
}