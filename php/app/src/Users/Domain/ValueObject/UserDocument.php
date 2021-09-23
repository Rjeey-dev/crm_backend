<?php
declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

use App\Core\Domain\ValueObject\File;

class UserDocument extends File
{
    protected $public = false;
    private $userId;

    public function __construct(array $file, string $userId)
    {
        parent::__construct($file);

        $this->userId = $userId;
    }

    public function getLocation(string $resolution = File::RESOLUTION_DEFAULT_NAME): string
    {
        return sprintf('profile_images/%s/%s', $resolution, $this->userId);
    }

    public function imageName(): string
    {
        return sprintf('document_%s', $this->getName());
    }
}