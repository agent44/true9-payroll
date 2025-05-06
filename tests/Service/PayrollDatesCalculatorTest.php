<?php

namespace App\Tests\Service;

use App\Service\PayrollDatesCalculator;
use App\Tests\ApiDataProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PayrollDatesCalculatorTest extends TestCase
{
    use ApiDataProvider;

    /**
     * @param int $year
     * @param int $month
     * @param array<string, string> $expectedResult
     *
     * @return void
     */
    #[DataProvider('calculatePayrollDatesProvider')]
    public function testCalculatePayDates(int $year, int $month, array $expectedResult): void
    {
        $payrollDate = new PayrollDatesCalculator();
        $result = $payrollDate->calculatePayDates($year, $month);
        $this->assertEquals($expectedResult, $result);
    }
}
