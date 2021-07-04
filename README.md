## Installation

```shell
composer require vim/messenger-lock
```

## Configuration

`config/packages/messenger.yaml`
```yaml
framework:
  messenger:
    #...
    buses:
      messenger.bus.default:
        middleware:
          - Vim\MessengerLock\Middleware\MessageIdMiddleware
```

`api/config/bundles.php`
```PHP
<?php
return [
  // ...
  Vim\MessengerLock\MessengerLockBundle::class => ['all' => true],
];
```

## Example

```PHP
<?php
class TestMessage extends \Vim\MessengerLock\Message\AbstractMessage
{
}
```
