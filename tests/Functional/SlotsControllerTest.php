<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SlotsControllerTest extends WebTestCase
{
    public function testFetchingLongList()
    {
        $client = static::createClient();
        $client->request('GET', '/slots');

        self::assertResponseIsSuccessful();
    }
}
