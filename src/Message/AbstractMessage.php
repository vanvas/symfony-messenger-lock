<?php
declare(strict_types=1);

namespace Vim\MessengerLock\Message;

abstract class AbstractMessage implements MessageInterface
{
    use MessageTrait;
}
