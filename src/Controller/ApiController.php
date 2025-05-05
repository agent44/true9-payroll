<?php

namespace App\Controller;

use App\Dto\PayRollDatesRequest;
use App\Service\PayrollDatesCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/', name: 'api_')]
final class ApiController extends AbstractController
{
    #[Route('payroll/dates', name: 'payroll_dates', methods: ['POST'])]
    public function dates(
        #[MapRequestPayload] PayRollDatesRequest $payRollDatesRequest,
        PayrollDatesCalculator $payrollDate,
        SerializerInterface $serializer,
    ): Response {
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '^(localhost|127\.0\.0\.1)$');
        $response->setJson(
            $serializer->serialize(
                $payrollDate->calculatePayDates($payRollDatesRequest->year, $payRollDatesRequest->month),
                'json'
            )
        );
        return $response;
    }
}
