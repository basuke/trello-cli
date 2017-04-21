<?php

use Clim\Container;
use Symfony\Component\Dotenv\Dotenv;

define('TRELLO_RC', dirname(__DIR__) . '/.env');
define('TRELLO_USER_RC', getenv('HOME') . '/.trellorc');

try {
    (new Dotenv())->load(TRELLO_RC, TRELLO_USER_RC);
} catch (\Exception $e) {
}

$container = new Container([
    'settings' => [
        'api_token' => getenv('TRELLO_API_TOKEN'),
    ]
]);

return $container;
