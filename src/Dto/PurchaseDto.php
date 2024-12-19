<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseDto extends CalculateDto
{
    #[Assert\NotBlank(message: 'not_blank')]
    #[Assert\Type('string')]
    private string $paymentProcessor;

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(string $paymentProcessor): self
    {
        $this->paymentProcessor = $paymentProcessor;
        return $this;
    }
}
