<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Domain\Authentication\Enum\LanguageEnum;
use App\Domain\Authentication\Enum\RoleEnum;
use App\Domain\Authentication\Model\User;
use App\Infrastructure\Authentication\ApiPlatform\Provider\UserCrudProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'User',
//    operations: [
//        new GetCollection(provider: UserCrudProvider::class),
//        new Get(provider: UserCrudProvider::class),
//        new Post(validationContext: ['groups' => ['create']], processor: UserCrudProcessor::class),
//        new Put(processor: UserCrudProcessor::class),
//        new Patch(processor: UserCrudProcessor::class),
//        new Delete(processor: UserCrudProcessor::class),
//    ],
)]
class UserResource
{
    #[Assert\NotBlank(message: 'assert.not_blank.username')]
    #[Groups(['user-write', 'user-list'])]
    private string $username;

    #[ApiProperty(writable: false, identifier: true)]
    #[Groups(['user-list'])]
    private string $uuid;

    #[ApiProperty(
        openapiContext: [
            'type' => 'array',
            'items' => ['$ref' => '#/components/schemas/Role'],
            'uniqueItems' => true,
        ]
    )]
    #[Assert\Choice(callback: [RoleEnum::class, 'getChoices'], multiple: true)]
    #[Groups(['user-write'])]
    private array $roles;

    #[ApiProperty(
        openapiContext: [
            '$ref' => '#/components/schemas/Locale',
        ]
    )]
    #[Assert\Choice(callback: [LanguageEnum::class, 'getChoices'])]
    #[Groups(['user-write', 'user-list'])]
    private string $locale;

    #[Groups(['user-list'])]
    private ?\DateTime $lastLogin;

    #[ApiProperty(
        openapiContext: [
            'format' => 'password',
        ],
    )]
    #[Groups(['user-write', 'user-update-write'])]
    private ?string $plainPassword = null;

    #[ApiProperty(
        openapiContext: [
            'format' => 'password',
        ],
    )]
    #[Groups(['user-update-write'])]
    private ?string $oldPassword = null;

    public static function fromModel(User $user): static
    {
        $resource = new self();
        $resource
            ->setUsername($user->getUsername())
            ->setUuid($user->getUuid())
            ->setRoles($user->getRoles())
            ->setLocale($user->getLocale())
            ->setLastLogin($user->getLastLogin())
        ;

        return $resource;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTime $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(?string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }
}
