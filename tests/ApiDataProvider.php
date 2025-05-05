<?php

namespace App\Tests;

trait ApiDataProvider
{
    public static function calculatePayrollDatesProvider(): array
    {
        return [
            // Happy path, expected year and month combinations
            [2025, 5, ['payday' => 'Fri, May 30, 2025', 'payment_date' => 'Mon, May 26, 2025']],
            [2025, 7, ['payday' => 'Wed, Jul 30, 2025', 'payment_date' => 'Thu, Jul 24, 2025']],
            [2025, 9, ['payday' => 'Mon, Sep 29, 2025', 'payment_date' => 'Tue, Sep 23, 2025']],
            [2025, 11, ['payday' => 'Fri, Nov 28, 2025', 'payment_date' => 'Mon, Nov 24, 2025']],
            [2026, 1, ['payday' => 'Fri, Jan 30, 2026', 'payment_date' => 'Mon, Jan 26, 2026']],
            // Still functional but somewhat nonsensical param combinations
            [2025, 32, ['payday' => 'Mon, Aug 30, 2027', 'payment_date' => 'Tue, Aug 24, 2027']],
            [2020, 13, ['payday' => 'Fri, Jan 29, 2021', 'payment_date' => 'Mon, Jan 25, 2021']],
            [2030, 12, ['payday' => 'Mon, Dec 30, 2030', 'payment_date' => 'Tue, Dec 24, 2030']],
        ];
    }
}
