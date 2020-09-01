# playwright-php


Install with composer
```bash
composer require luka-dev/playwright-php
```

A PHP Module, that help with generating of task script for playwright and send it node.js server 

All detailed information [here](https://github.com/luka-dev/playwright-task-server)

Code example
```php
$config = new \ConnectionConfig('localhost');
$taskServer = new \TaskServer($config);
$script = new Context();
$page = $script->newPage();
$page->goto('https://2ip.ru/');
$element = $page->query('div.ip');
$element->textContentToVar('data.ip');
$response = $taskServer->runTask($script);
$response->getData();
```
