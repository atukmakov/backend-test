<?php

namespace App\Tests\Service;

use App\Service\PaymentService;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PaymentServiceTest extends KernelTestCase
{
    private ContainerInterface $container;

    public function setUp(): void
    {
        $this->container = self::bootKernel()->getContainer();
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @see PaymentService::pay()
     */
    public function testPayCase1()
    {
        /** @var PaymentService $paymentService */
        $paymentService = $this->container->get(PaymentService::class);
        $result = $paymentService->pay(1000, 'paypal');

        $this->assertTrue($result);
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @see PaymentService::pay()
     */
    public function testPayCase2()
    {
        /** @var PaymentService $paymentService */
        $paymentService = $this->container->get(PaymentService::class);
        $result = $paymentService->pay(10000000, 'paypal');

        $this->assertFalse($result);
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @see PaymentService::pay()
     */
    public function testPayCase3()
    {
        /** @var PaymentService $paymentService */
        $paymentService = $this->container->get(PaymentService::class);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Payment method not found');
        $paymentService->pay(1000, 'paypalll');
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @see PaymentService::pay()
     */
    public function testPayCase4()
    {
        /** @var PaymentService $paymentService */
        $paymentService = $this->container->get(PaymentService::class);
        $result = $paymentService->pay(10000000, 'stripe');

        $this->assertTrue($result);
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @see PaymentService::pay()
     */
    public function testPayCase5()
    {
        /** @var PaymentService $paymentService */
        $paymentService = $this->container->get(PaymentService::class);
        $result = $paymentService->pay(10, 'stripe');

        $this->assertFalse($result);
    }
}