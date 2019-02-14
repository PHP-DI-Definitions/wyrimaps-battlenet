<?php declare(strict_types=1);

use ApiClients\Foundation\Options as FoundationOptions;
use ApiClients\Foundation\Transport\Options as TransportOptions;
use React\EventLoop\LoopInterface;
use WyriMaps\BattleNet\AsyncClient;
use WyriMaps\BattleNet\AsyncClientInterface;
use WyriMaps\BattleNet\Authentication\ClientCredentials;
use WyriMaps\BattleNet\Middleware\ClientCredentialsMiddleware;
use WyriMaps\BattleNet\Options;
use function DI\factory;
use function DI\get;

return [
    AsyncClientInterface::class => factory(function (string $authKey, string $authSecret, string $cacheKey, LoopInterface $loop) {
        return AsyncClient::create(
            $loop,
            new ClientCredentials(
                $authKey,
                $authSecret
            ),
            [
                FoundationOptions::TRANSPORT_OPTIONS => [
                    TransportOptions::MIDDLEWARE => [
                        ClientCredentialsMiddleware::class,
                    ],
                    TransportOptions::DEFAULT_REQUEST_OPTIONS => [
                        ClientCredentialsMiddleware::class => [
                            Options::API_TOKEN_CACHE_KEY => $cacheKey,
                        ],
                    ],
                ],
            ]
        );
    })
        ->parameter('authKey', get('config.wyrimaps.battlenet.auth.key'))
        ->parameter('authSecret', get('config.wyrimaps.battlenet.auth.secret'))
        ->parameter('cacheKey', get('config.wyrimaps.battlenet.cache.key')),
];
