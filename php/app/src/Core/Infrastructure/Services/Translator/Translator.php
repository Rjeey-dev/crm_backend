<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Services\Translator;

use Symfony\Contracts\Translation\TranslatorInterface as BaseTranslatorInterface;

class Translator implements TranslatorInterface
{
    private $translator;

    public function __construct(BaseTranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public static function buildNotificationSubjectId(string $id): string
    {
        return sprintf('notification.mail.subjects.%s', $id);
    }

    public function translate(
        string $id,
        string $locale,
        string $domain = I18nTranslation::DOMAIN_COMMON,
        array $parameters = []
    ): string {
        return $this->translator->trans($id, $parameters, $domain, $locale);
    }
}
