<?php
declare(strict_types=1);

namespace App\Kernel\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;

abstract class DocumentRepository
{
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    protected function getDocumentManager(): DocumentManager
    {
        return $this->documentManager;
    }
}
