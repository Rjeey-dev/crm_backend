<?php
declare(strict_types=1);

namespace App\Tests;

use App\Tests\Fixture\FixturesTrait;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OdmTestCase extends WebTestCase
{
    use FixturesTrait;

    protected $dm;
    protected $entityManagerServiceId = 'doctrine_mongodb.odm.document_manager';

    protected function setUp(): void
    {
        parent::setUp();

        if (static::$kernel === null) {
            static::$kernel = static::createKernel([
                'environment' => 'test',
                'debug' => false,
            ]);

            exec(sprintf('rm -rf %s', static::$kernel->getCacheDir() . '/*'));
        }

        static::$kernel->boot();

        $container = static::$kernel->getContainer();
        $this->dm = $container->get($this->entityManagerServiceId);
    }

    protected function getDocumentManager(): DocumentManager
    {
        return $this->dm;
    }
}
