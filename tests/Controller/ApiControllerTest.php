<?php

namespace App\Tests\Controller;

use App\Tests\ApiDataProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ApiControllerTest extends WebTestCase
{
    use ApiDataProvider;

    #[DataProvider('calculatePayrollDatesProvider')]
    public function testPayrollDates(int $year, int $month, array $expectedResult): void
    {
        $expectedResult = json_encode($expectedResult);
        $response = $this->sendRequest($year, $month);

        // Make assertions based on whether we have submitted valid data or not.
        if ($month >= 1 && $month <= 12) {
            self::assertResponseIsSuccessful();
            self::assertSame($expectedResult, $response->getContent());
            self::assertResponseStatusCodeSame(200);
            self::assertResponseHeaderSame('Content-type', 'application/json');
        } elseif (!is_numeric($month) || !is_numeric($year)) {
            self::assertResponseIsUnprocessable();
            self::assertResponseStatusCodeSame(422);
            self::assertResponseHeaderSame('Content-type', 'text/html; charset=UTF-8');
        } else {
            self::assertResponseIsUnprocessable();
            self::assertResponseStatusCodeSame(422);
            self::assertResponseHeaderSame('Content-type', 'text/html; charset=UTF-8');
        }
    }

    public static function invalidPayrollDatesProvider(): array
    {
        return [
            ['bhst', 'ab'],
            ['0000', '00'],
            ['hjdqwhdoihqo', '09987654'],
            ['*(', '////()'],
        ];
    }

    #[DataProvider('invalidPayrollDatesProvider')]
    public function testInvalidPayrollDates(string $year, string $month): void
    {
        $this->sendRequest($year, $month);
        self::assertResponseIsUnprocessable();
        self::assertResponseStatusCodeSame(422);
        self::assertResponseHeaderSame('Content-type', 'text/html; charset=UTF-8');
    }

    private function sendRequest(string|int $year, string|int $month)
    {
        $payload = json_encode(['year' => $year, 'month' => $month]);
        $client = self::createClient();

        $client->request(
            'POST',
            '/api/payroll/dates',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $payload
        );

        return $client->getResponse();
    }
}
