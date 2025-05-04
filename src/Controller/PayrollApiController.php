<?php

namespace App\Controller;

use App\Dto\PayRollDatesRequest;
use App\Service\PayrollDatesCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/', name: 'api_')]
final class PayrollApiController extends AbstractController
{
    #[Route('payroll/dates', name: 'payroll_dates', methods: ['POST'])]
    public function dates(
        #[MapRequestPayload] PayRollDatesRequest $payRollDatesRequest,
        PayrollDatesCalculator                   $payrollDate,
    ): Response {
        dump($payRollDatesRequest);

        return $this->json($payrollDate->calculatePayDates($payRollDatesRequest->year, $payRollDatesRequest->month));
    }
}
