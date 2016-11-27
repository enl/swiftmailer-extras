# Swiftmailer extras

This library adds two facilities two [Swiftmailer library](http://swiftmailer.org):

* Adapter to PSR-3 compatible logger;
* Mailer class that can switch from messages spooling to realtime sending.

## Logging ##

To use any kind of PSR-3 compatible logger with Swift you need to register plugin with logging adatper:

```php
use Enl\Swiftmailer\Logger\PsrAdapter;

$logger = new Logger(); // Logger MUST implement \Psr\Log\LoggerInterface
$adapter = new PsrAdapter($logger);

$mailer = new Swift_Mailer();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($adapter));
```


## Optional Spooling ##

As you know, to use Spool facility for `Swift_Mailer`, you need to define transport like this:

```php
$transport = new Swift_Transport_SpoolTransport(new Swift_MemorySpool());
$mailer = new Swift_Mailer($transport);
```

It is absolutely OK until you need to send _this email right now_... To achieve this goal, I created a wrapper for swift mailer, which does the trick:

```php
$realTransport = new Swift_Transport_NullTransport();
$spool = new Swift_MemorySpool();
$mailer = new Enl\Swifthmailer\Mailer($realTransport, $spool);
```

To send the message to a queue you should use mailer as usual:

```php
$mailer->send(new Swift_Message());
```

To _immediately_ send exactly one message you should use `immediately` function before sending:

```php
$mailer->immediately()->send(new Swift_Message());
// Next message will be sent to a queue!
$mailer->send(new Swift_Message());
```



