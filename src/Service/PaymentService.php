<?php

namespace App\Service;

use Exception;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentService
{
    public function __construct(
        readonly PaypalPaymentProcessor $paypalPaymentProcessor,
        readonly StripePaymentProcessor $stripePaymentProcessor
    ) {
    }

    private const array PAYMENT_METHODS = [
        'paypal' => 'paypalPay',
        'stripe' => 'stripePay',
    ];

    /**
     * @throws Exception
     */
    public function pay(string $price, string $paymentMethod): bool
    {
        if (!array_key_exists($paymentMethod, self::PAYMENT_METHODS)) {
            throw new Exception('Payment method not found');
        }

        $method = self::PAYMENT_METHODS[$paymentMethod];

        return $this->$method($price);
    }

    private function paypalPay(string $price): bool
    {
        try {
            $this->paypalPaymentProcessor->pay((int) $price);
        } catch (Exception) {
            return false;
        }

        return true;
    }

    private function stripePay(string $price): bool
    {
        return $this->stripePaymentProcessor->processPayment((float)$price);
    }
}