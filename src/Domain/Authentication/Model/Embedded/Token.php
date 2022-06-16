<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Model\Embedded;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Token
{
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $value = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $expiredAt = null;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getExpiredAt(): ?\DateTime
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(?\DateTime $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    public function erase(): self
    {
        $this->value = null;
        $this->expiredAt = null;

        return $this;
    }

    public function isValid(): bool
    {
        return !(null === $this->expiredAt) && $this->expiredAt > new \DateTime();
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'expiredAt' => $this->expiredAt->format('c'),
        ];
    }
}
