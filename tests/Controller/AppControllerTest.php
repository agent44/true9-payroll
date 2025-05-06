<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

final class AppControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertResponseIsSuccessful();

        $content = $client->getResponse()->getContent();
        $crawler = new Crawler($content);

        // Check main elements of the page are present
        $selects = $crawler->filterXPath('//select');
        self::assertCount(2, $selects);

        $button = $crawler->filterXPath('//button');
        self::assertCount(1, $button);

        $resultsPanel = $crawler->filterXPath('//div[contains(@id, "results")]');
        self::assertCount(1, $resultsPanel);

        $isHidden = $resultsPanel->filterXPath('//div[contains(@class, "hidden")]');
        self::assertCount(1, $isHidden);
    }
}
