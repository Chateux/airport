<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NumberOfPlaceProperties extends Constraint
{
    public $message = 'Th number of passenger for this flight is full...';
}