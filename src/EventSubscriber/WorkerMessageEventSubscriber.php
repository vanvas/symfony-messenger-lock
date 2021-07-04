<?php
declare(strict_types=1);

namespace Vim\MessengerLock\EventSubscriber;

use JetBrains\PhpStorm\ArrayShape;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Vim\MessengerLock\Exception\IsLockedException;
use Vim\MessengerLock\Message\MessageInterface;

class WorkerMessageEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private LockFactory $lockFactory, private LoggerInterface $logger)
    {
    }

    #[ArrayShape([WorkerMessageReceivedEvent::class => "string[]"])]
    public static function getSubscribedEvents(): array
    {
        return [
            WorkerMessageReceivedEvent::class => [
                'onMessageReceived'
            ],
        ];
    }

    public function onMessageReceived(WorkerMessageReceivedEvent $event): void
    {
        $message = $event->getEnvelope()->getMessage();
        if (!$message instanceof MessageInterface) {
            return;
        }

        $lock = $this->lockFactory->createLock('message.lock.' . $message->getMessageId());
        if (!$lock->acquire()) {
            $this->logger->debug('Message already locked', [
                'message' => $message,
            ]);

            throw new IsLockedException();
        }
    }
}