<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model;

trait TimestampableTrait
{
    private \DateTime $dateCreated;
    private \DateTime $dateModified;

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    public function getDateModified(): \DateTime
    {
        return $this->dateModified;
    }

}
