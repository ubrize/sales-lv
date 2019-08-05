# Sales.lv SMS notifications for Laravel 5.3+

## Installation

You can install the package via composer:

```bash
composer require ubrize/sales-lv
```

### Setting up sales.lv SMS notifications

Add sales.lv configuration to `config/services.php`:

```php
// config/services.php

...
'saleslv' => [
    'key' => env('SALESLV_KEY'),
    'sender' => env('SALESLV_SENDER', 'Example Sender'),
    'endpoint' => env('SALESLV_ENDPOINT', 'https://traffic.sales.lv/API:0.14/'),
],
...
```
