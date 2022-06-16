<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Enum;

class StatusEnum
{
    public const EMAIL_PENDING_VALIDATION_STATUS = 'email_pending_validation';
    public const EMAIL_VALID_STATUS = 'email_valid';
    public const WAITING_PASSWORD_CHANGE_STATUS = 'waiting_password_change';
    public const PASSWORD_VALID_STATUS = 'password_valid';
    public const UNBLOCKED_STATUS = 'unblocked';
    public const BLOCKED_STATUS = 'blocked';
}
