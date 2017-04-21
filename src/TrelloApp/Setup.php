<?php

namespace TrelloApp;

use Psr\Container\ContainerInterface;

class Setup
{
    public function __construct(ContainerInterface $c)
    {
        $this->c = $c;
    }

    public function __invoke($context, $next)
    {
        $key = getenv('TRELLO_API_KEY');

        if (empty($key)) {
            $output = $this->c->output;

            $output->error('TRELLO_API_KEY is not defined');
            return;
        }

        $secret = getenv('TRELLO_API_SECRET');

        if (empty($secret)) {
            $output = $this->c->output;

            $output->error('TRELLO_API_SECRET is not defined');
            return;
        }

        $this->c['trello'] = function ($c) {
            $client = new Stevenmaguire\Services\Trello\Client([
                'domain' => 'https://trello.com',
                'scope' => 'read,write',

                'key' => $key,
                'secret' => $secret,

                'callbackUrl' => 'http://your.domain/oauth-callback-url',
                'expiration' => '3days',
                'name' => 'My sweet trello enabled app',
                'token'  => 'abcdefghijklmnopqrstuvwxyz',
                'version' => '1',
                'proxy' => 'tcp://localhost:8125',
            ]);

            return $client;
        };
        return $next($context);
    }
}