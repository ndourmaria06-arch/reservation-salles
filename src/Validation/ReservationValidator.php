<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

final class ReservationValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $rules = [
            'salle_id' => v::intVal()->positive(),
            'responsable' => v::stringType()->length(2, 120),
            'email' => v::email(),
            'motif' => v::stringType()->length(5, 255),
            'date_debut' => v::dateTime('Y-m-d H:i'),
            'date_fin' => v::dateTime('Y-m-d H:i'),
            
        ];

        $errors = [];

        foreach ($rules as $field => $rule) {
            try {
                $rule->assert($data[$field] ?? null);
            } catch (NestedValidationException $exception) {
                $errors[$field] = $exception->getMessages()[0] ?? "Le champ {$field} est invalide.";
            }
        }

        if ($errors !== []) {
            return ValidationResult::failure($errors);
        }

        return ValidationResult::success($data);
    }
}