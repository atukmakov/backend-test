<?php

namespace App\Validator;

use App\Repository\CountryTaxRepository;
use App\Trait\TaxNumberTrait;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Валидатор для налоговых номеров, который проверяет идентификатор на основе шаблона из базы данных.
 */
class TaxNumberValidator extends ConstraintValidator
{
    use TaxNumberTrait;
    public function __construct(readonly CountryTaxRepository $countryTaxRepository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        $templates = $this->countryTaxRepository->findAll();

        $isEqual = false;

        foreach ($templates as $template) {

            $pattern = $this->generatePattern($template->getTaxNumber());

            if (true === $isEqual = $this->compareNumberPattern($pattern, $value)) {
                break;
            }
        }

        if (false === $isEqual) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
