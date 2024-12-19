<?php

namespace App\Controller;

use App\Dto\CalculateDto;
use App\Dto\PurchaseDto;
use App\Exception\ApiException;
use App\Service\PurchaseService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PurchaseController extends AbstractController
{
    public function __construct(readonly PurchaseService $purchaseService)
    {
    }

    #[Route('/purchase', name: 'app_purchase', methods: ['POST'], format: 'json')]
    public function purchase(
        #[MapRequestPayload(
            acceptFormat: 'json',
            validationFailedStatusCode: Response::HTTP_BAD_REQUEST
        )] PurchaseDto $purchaseDto,
    ): JsonResponse
    {

        try {
            $this->purchaseService->purchase($purchaseDto);
        } catch (Exception $e) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }

        return $this->json([]);
    }

    #[Route('/calculate-price', name: 'app_calculate_price', methods: ['POST'], format: 'json')]
    public function calculatePrice(
        #[MapRequestPayload(
            acceptFormat: 'json',
            validationFailedStatusCode: Response::HTTP_BAD_REQUEST
        )] CalculateDto $calculateDto,
    ): JsonResponse
    {
        try {
            return $this->json([
                'price' => $this->purchaseService->calculate($calculateDto)
            ]);
        } catch (Exception $e) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
