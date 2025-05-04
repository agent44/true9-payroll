<?php

namespace App\Tests\Service;

use App\Service\PayrollDate;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PayrollDateTest extends TestCase
{
    public static function calculatePayDatesProvider(): array
    {
        return [
            // Happy path, expected year and month combinations
            [2025, 5, ['payday' => '2025-05-30', 'payment_date' => '2025-05-26']],
            [2025, 7, ['payday' => '2025-07-30', 'payment_date' => '2025-07-24']],
            [2025, 9, ['payday' => '2025-09-29', 'payment_date' => '2025-09-23']],
            [2025, 11, ['payday' => '2025-11-28', 'payment_date' => '2025-11-24']],
            [2025, 11, ['payday' => '2025-11-28', 'payment_date' => '2025-11-24']],
            // Still functional but somewhat nonsensical param combinations
            [2025, 32, ['payday' => '2027-08-30', 'payment_date' => '2027-08-24']],
            [2020, 13, ['payday' => '2021-01-29', 'payment_date' => '2021-01-25']],
            [2030, 12, ['payday' => '2030-12-30', 'payment_date' => '2030-12-24']],
        ];
    }

    #[DataProvider('calculatePayDatesProvider')]
    public function testCalculatePayDates(int $year, int $month, array $expectedResult): void
    {
        $payrollDate = new PayrollDate();
        $result = $payrollDate->calculatePayDates($year, $month);
        dump($expectedResult, $result);
        $this->assertEquals($expectedResult, $result);
    }
}
