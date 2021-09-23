<?php
declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Users\Domain\Event\UserCreatedEvent;
use App\Users\Domain\Event\UserLoggedOutEvent;
use App\Users\Domain\Event\UserStateHasBeenChangedEvent;
use App\Users\Domain\ValueObject\Settings;
use App\Users\Domain\ValueObject\Role;
use App\Users\Domain\ValueObject\UserId;
use App\Users\Domain\ValueObject\UserLogin;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use NinjaBuggs\ServiceBus\Event\EventRecordableInterface;
use NinjaBuggs\ServiceBus\Event\EventRecordableTrait;

/**
 * @MongoDB\Document
 */
class User implements EventRecordableInterface
{
    use EventRecordableTrait;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Id(strategy="NONE", type="users:user_id")
     */
    private $id;

    /**
     * @MongoDB\Field(type="users:user_login")
     */
    private $login;

    /**
     * @MongoDB\Field(type="string")
     */
    private $email;

    /**
     * @MongoDB\Field(type="string")
     */
    private $image;

    /** @MongoDB\EmbedOne(targetDocument="\App\Users\Domain\ValueObject\Settings") */
    private $settings;

    /** @MongoDB\EmbedOne(targetDocument="\App\Users\Domain\ValueObject\Role") */
    private $role;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $modified;

    public function __construct(
        UserId $id,
        string $name,
        UserLogin $login,
        Settings $settings,
        Role $role,
        ?string $email = null,
        ?string $image = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->settings = $settings;
        $this->role = $role;
        $this->created = new \DateTimeImmutable();
        $this->modified = new \DateTimeImmutable();
        $this->image = $image;
        $this->email = $email;

        $this->recordEvent(
            new UserCreatedEvent(
                $id->getId(),
                $name,
                $login->getLogin(),
                $role,
                $this->created,
                $image,
                $email
            )
        );
    }

    public function logOut(): void
    {
        $this->modified = new \DateTimeImmutable();

        $this->recordEvent(new UserLoggedOutEvent($this->id->getId()));
        $this->recordEvent(new UserStateHasBeenChangedEvent($this->id->getId()));
    }
}
