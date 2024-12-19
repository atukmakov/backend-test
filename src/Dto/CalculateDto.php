<?php

namespace App\Dto;

use App\Validator\TaxNumber;
use Symfony\Component\Validator\Constraints as Assert;

class CalculateDto implements CalculateDtoInterface
{
    #[Assert\NotBlank(message: 'not_blank')]
    #[Assert\Type('integer')]
    private int $product;

    #[Assert\NotBlank(message: 'not_blank')]
    #[Assert\Type('string')]
    #[TaxNumber]
    private string $taxNumber;

    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 4)]
    private ?string $couponCode = null;

    #[Assert\NotBlank(message: 'not_blank')]
    public function getProduct(): int
    {
        return $this->product;
    }

    public function setProduct(int $product): CalculateDto
    {
        $this->product = $product;
        return $this;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;
        return $this;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function setCouponCode(?string $couponCode): self
    {
        $this->couponCode = $couponCode;
        return $this;
    }
}
