# playwright-php


Install with composer
```bash
composer require luka-dev/playwright-php
```

A PHP Module, that help with generating of task script for playwright and send it node.js server 

All detailed information [here](https://github.com/luka-dev/playwright-task-server)

Code example
```php
$connectionConfig = new \ConnectionConfig('localhost');

$contextConfig = new ContextConfig();

$contextConfig->setUserAgent('Custom UserAgent');
$contextConfig->setProxy(
    'protocol://address:port',
    null,
    'username',
    'password'
);


$taskServer = new \TaskServer($connectionConfig, $contextConfig);

$script = new Context();

$page = $script->newPage();
$page->goto('https://2ip.ru/');
$element = $page->query('div.ip');
$element->textContentToVar('ip');
$script->resolve('ip');

$response = $taskServer->runTask($script);
```
