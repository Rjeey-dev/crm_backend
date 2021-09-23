<?php
declare(strict_types=1);

namespace App\Tests\Fixture;

use Doctrine\Common\DataFixtures\Executor\MongoDBExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\MongoDBPurger;

trait FixturesTrait
{
    protected function loadFixtures(array $fixtures): void
    {
        $loader = new Loader();

        foreach ($fixtures as $fixture) {
            $loader->addFixture($fixture);
        }

        $purger = new MongoDBPurger();
        $executor = new MongoDBExecutor($this->getDocumentManager(), $purger);
        $executor->execute($loader->getFixtures(), true);
    }
}
