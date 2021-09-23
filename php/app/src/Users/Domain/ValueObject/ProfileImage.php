<?php
declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

use App\Core\Domain\ValueObject\File;
use App\Core\Domain\ValueObject\Image;
use App\Core\Domain\ValueObject\ImageResolution;

class ProfileImage extends Image
{
    private $userId;

    public function __construct(array $file, string $userId)
    {
        parent::__construct($file);

        $this->userId = $userId;

        $this->addResolution(new ImageResolution(ImageResolution::IMAGE_RESOLUTION_THUMBNAIL, 256, 256));
    }

    public static function getDefaultResolutions(): array
    {
        return [
            ImageResolution::IMAGE_RESOLUTION_NORMAL,
            ImageResolution::IMAGE_RESOLUTION_THUMBNAIL,
        ];
    }

    public static function getLocationByUserId(string $id, string $resolution = File::RESOLUTION_DEFAULT_NAME): string
    {
        return sprintf('public/files/profile_images/%s/%s', $resolution, $id);
    }

    public function getLocation(string $resolution = File::RESOLUTION_DEFAULT_NAME): string
    {
        $mode = $this->public ? self::FILE_MODE_PUBLIC : self::FILE_MODE_PRIVATE;

        return sprintf('%s/files/profile_images/%s/%s/%s', $mode, $resolution, $this->userId, $this->getName());
    }
}
