<?php
declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

use App\Users\Domain\DTO\User as UserDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\EmbeddedDocument */
class User
{
    /**
     * @MongoDB\Field(name="user_id", type="string")
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(type="string")
     */
    private $login;

    /**
     * @MongoDB\Field(type="string")
     */
    private $image;

    /** @MongoDB\EmbedOne(targetDocument="\App\Users\Domain\ValueObject\Role") */
    private $role;

    /** @MongoDB\EmbedMany(targetDocument="\App\Users\Domain\ValueObject\Review") */
    private $reviews;

    /** @MongoDB\EmbedOne(targetDocument="\App\Users\Domain\ValueObject\Level") */
    private $level;

    /**
     * @MongoDB\Field(type="float")
     */
    private $rating;

    public function __construct(
        string $id,
        string $login,
        Level $level,
        ?string $name,
        ?string $image,
        ?Role $role = null,
        ?array $reviews = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->login = $login;
        $this->level = $level;
        $this->role = $role;
        $this->reviews = new ArrayCollection();
        $this->rating = 0.0;

        foreach ($reviews as $review) {
            $this->reviews->add($review);
        }

        if (count($reviews) < 1) {
            return;
        }

        $rating = 0.0;
        foreach ($reviews as $review) {
            $rating += $review->getRating();
        }

        $this->rating = $rating / count($reviews);
    }

    public function withNewRating(float $rating): self
    {
        $user = clone $this;

        $user->rating = $rating;

        return $user;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function isEqual(string $id): bool
    {
        return $this->id === $id;
    }

    /**
     * @return Review[]|ArrayCollection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    public function addReview(Review $review): void
    {
        $this->reviews->add($review);
    }

    public function getLevel(): Level
    {
        return $this->level;
    }

    public static function createFromUserDTO(UserDTO $user): self
    {
        $reviews = [];

        foreach ($user->getReviews() as $review) {
            $reviews[] = Review::createFromReviewDTO($review);
        }

        return new self(
            $user->getId(),
            $user->getLogin(),
            Level::createFromLevelDTO($user->getLevel()),
            $user->getName(),
            $user->getImage(),
            new Role(
                $user->getRoleName(),
                $user->getRole()->getUpdated()
            ),
            $reviews
        );
    }

    public function createWithUpdatedValues(
        ?string $name = null,
        ?string $newImage = null,
        ?string $newLogin = null,
        ?Level $level = null,
        ?Role $role = null,
        ?Review $review = null,
        ?float $rating = null
    ): self {
        if ($review) {
            $this->reviews->add($review);
        }

        $user = new self(
            $this->id,
            $newLogin ?? $this->login,
            $level ?? $this->level,
            $name ?? $this->name,
            $newImage ?? $this->image,
            $role ?? $this->role,
            $this->reviews->toArray()
        );

        if ($rating) {
            $user = $user->withNewRating($rating);
        }

        return $user;
    }
}
