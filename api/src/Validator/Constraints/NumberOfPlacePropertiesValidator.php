<?php

namespace App\Validator\Constraints;

use App\Entity\Flight;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
final class NumberOfPlacePropertiesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        $flight = new Flight();
        $this->context->buildViolation($constraint->message)->addViolation();
    }
}