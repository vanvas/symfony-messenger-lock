<?php
declare(strict_types=1);

namespace Vim\MessengerLock\Message;

interface MessageInterface
{
    public function getMessageId(): ?string;

    public function setMessageId(string $messageId): void;
}
