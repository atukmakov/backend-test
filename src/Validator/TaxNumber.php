<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class TaxNumber extends Constraint
{
    public string $message = '"{{ value }}" is not a valid tax number.';
}
