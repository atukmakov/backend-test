<?php

namespace App\Entity;

use App\Repository\CountryTaxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryTaxRepository::class)]
#[ORM\Index(name: "tax_number_idx", fields: ["taxNumber"])]
class CountryTax
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $country;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private string $tax;

    #[ORM\Column(length: 30)]
    private string $taxNumber;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getTax(): string
    {
        return $this->tax;
    }

    public function setTax(string $tax): static
    {
        $this->tax = $tax;

        return $this;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): static
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }
}
