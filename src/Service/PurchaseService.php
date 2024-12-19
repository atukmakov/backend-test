<?php

namespace App\Service;

use App\Dto\CalculateDto;
use App\Dto\CalculateDtoInterface;
use App\Dto\PurchaseDto;
use App\Repository\CountryTaxRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Trait\TaxNumberTrait;
use Exception;

class PurchaseService
{
    use TaxNumberTrait;

    public function __construct(
        readonly CountryTaxRepository $countryTaxRepository,
        readonly CouponRepository $couponRepository,
        readonly ProductRepository $productRepository,
        readonly PaymentService $paymentService
    ) {
    }

    /**
     * Расчет цены товара с учетом скидки по купону
     * @param CalculateDto $calculateDto
     * @return string
     * @throws Exception
     */
    public function calculate(CalculateDtoInterface $calculateDto): string
    {
        $product = $this->productRepository->find($calculateDto->getProduct());

        if (!$product) {
            throw new Exception('Product not found');
        }

        return $product->getPrice() * $this->getDiscount($calculateDto->getCouponCode()) * $this->getTax($calculateDto->getTaxNumber());
    }

    /**
     * Покупка товара
     * @throws Exception
     */
    public function purchase(PurchaseDto $purchaseDto): bool
    {
        $price = $this->calculate($purchaseDto);

        if (false === $this->paymentService->pay($price, $purchaseDto->getPaymentProcessor())) {
            throw new Exception('Failed to pay');
        }

        return true;
    }

    private function getTax(string $taxNumber): string
    {
        $tax = 1;

        $templates = $this->countryTaxRepository->findAll();

        foreach ($templates as $template) {
            $pattern = $this->generatePattern($template->getTaxNumber());

            if ($this->compareNumberPattern($pattern, $taxNumber)) {
                $tax = 1 + ($template->getTax() / 100);
                break;
            }
        }

        return (string) $tax;
    }

    private function getDiscount(?string $couponCode): string
    {
        $couponDiscount = 1;

        $coupon = $this->couponRepository->findOneBy([
            'name' => $couponCode
        ]);

        if ($coupon) {
            $couponDiscount = 1 - ($coupon->getDiscount() / 100);
        }

        return (string) $couponDiscount;
    }
}
