<?php

namespace App\Service;

use Carbon\Carbon;

class PayrollDatesCalculator
{
    /**
     * @return array<int|string, int|string>
     */
    public function calculatePayDates(int|string $year, int|string $month): array
    {
        $payday = Carbon::createFromDate($year, $month, 1)->endOfMonth()->subDays(1);

        if ($payday->isWeekend()) {
            $payday = $payday->previous(Carbon::FRIDAY);
        }

        $paymentDate = $payday->copy();
        $daysToSubtract = 0;

        while ($daysToSubtract < 4) {
            $paymentDate->subDay();
            if (!$paymentDate->isWeekend()) {
                ++$daysToSubtract;
            }
        }

        return [
            'payday' => $payday->toFormattedDayDateString(),
            'payment_date' => $paymentDate->toFormattedDayDateString(),
        ];
    }
}
