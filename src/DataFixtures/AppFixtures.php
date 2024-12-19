<?php

namespace App\DataFixtures;

use App\Entity\CountryTax;
use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getProductsFixture() as $value) {
            $product = new Product();
            $product->setName($value['name']);
            $product->setPrice($value['price']);
            $manager->persist($product);
        }

        foreach ($this->getCountryTaxFixture() as $value) {
            $countryTax = new CountryTax();
            $countryTax->setCountry($value['country']);
            $countryTax->setTax($value['tax']);
            $countryTax->setTaxNumber($value['taxNumber']);
            $manager->persist($countryTax);

        }

        foreach ($this->getCouponFixture() as $value) {
            $coupon = new Coupon();
            $coupon->setName($value['name']);
            $coupon->setDiscount($value['discount']);
            $manager->persist($coupon);
        }

        $manager->flush();
    }

    private function getProductsFixture(): array
    {
        return [
            [
                'name' => 'Iphone',
                'price' => '100.00',
            ],
            [
                'name' => 'Наушники',
                'price' => '20.00',
            ],
            [
                'name' => 'Чехол',
                'price' => '10.00',
            ],
        ];
    }

    private function getCountryTaxFixture(): array
    {
        return [
            [
                'country' => 'Германия',
                'tax' => '19',
                'taxNumber' => 'DEXXXXXXXXX',
            ],
            [
                'country' => 'Италия',
                'tax' => '22',
                'taxNumber' => 'ITXXXXXXXXXXX',
            ],
            [
                'country' => 'Франция',
                'tax' => '20',
                'taxNumber' => 'FRYYXXXXXXXXX',
            ],
            [
                'country' => 'Греция',
                'tax' => '24',
                'taxNumber' => 'GRXXXXXXXXX',
            ],
        ];
    }

    private function getCouponFixture(): array
    {
        return [
            [
                'name' => 'P10',
                'discount' => '10',
            ],
            [
                'name' => 'P15',
                'discount' => '15',
            ],
        ];
    }
}
