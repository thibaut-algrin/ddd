<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model;

use Doctrine\ORM\Mapping as ORM;

trait SoftDeletableTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $dateDeleted = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $deletedBy = null;

    public function getDateDeleted(): ?\DateTime
    {
        return $this->dateDeleted;
    }

    /**
     * @codeCoverageIgnore use in fixtures
     */
    public function setDateDeleted(\DateTime $dateDeleted): self
    {
        $this->dateDeleted = $dateDeleted;

        return $this;
    }

    public function getDeletedBy(): ?string
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(string $deletedBy): self
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }
}
