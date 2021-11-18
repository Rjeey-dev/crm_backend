<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Services\Translator;

interface TranslatorInterface
{
    public function translate(
        string $id,
        string $locale,
        string $domain = I18nTranslation::DOMAIN_COMMON,
        array $parameters = []
    ): string;
}
