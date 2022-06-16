<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Model;

use App\Domain\Authentication\Enum\LanguageEnum;
use App\Domain\Authentication\Enum\RoleEnum;
use App\Domain\Authentication\Enum\StatusEnum;
use App\Domain\Authentication\Model\Embedded\Token;
use App\Domain\Shared\Model as Behavior;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity()]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Behavior\SoftDeletableTrait;
    use Behavior\TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $username;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'json')]
    private array $roles;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'json')]
    private array $status;

    #[ORM\Column(type: 'string')]
    private string $locale;

    #[ORM\Embedded(class: Token::class)]
    private Token $token;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $lastLogin;

    private ?string $plainPassword;

    public function __construct()
    {
        $this->uuid = (string) Uuid::v4();
        $this->roles = [RoleEnum::USER];
        $this->status = [
            StatusEnum::EMAIL_VALID_STATUS => 1,
            StatusEnum::PASSWORD_VALID_STATUS => 1,
            StatusEnum::UNBLOCKED_STATUS => 1,
        ];
        $this->locale = LanguageEnum::FR;
        $this->lastLogin = null;
        $this->plainPassword = null;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStatus(): array
    {
        return $this->status;
    }

    public function setStatus(array $status): self
    {
        $this->status = $status;

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

    public function getToken(): Token
    {
        return $this->token;
    }

    public function setToken(Token $token): self
    {
        $this->token = $token;

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

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

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}
