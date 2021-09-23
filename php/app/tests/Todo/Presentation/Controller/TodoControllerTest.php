<?php
declare(strict_types=1);

namespace App\Tests\Todo\Presentation\Controller;

use App\Tests\Fixture\Todo\Tasks;
use App\Tests\OdmTestCase;

class TodoControllerTest extends OdmTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([
            new Tasks(),
        ]);
    }

    public function testListAction(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/tasks');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);

        $this->assertCount(3, $content);
    }
}
