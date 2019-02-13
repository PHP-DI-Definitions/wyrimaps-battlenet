<?php declare(strict_types=1);

use Clue\React\Redis\Client;
use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;
use WyriHaximus\React\Redis\WaitingClient\WaitingClient;
use function DI\factory;
use function DI\get;
use WyriMaps\BattleNet\AsyncClient;

return [
    AsyncClient::class => factory(function (string $key, LoopInterface $loop) {
        return new AsyncClient($key, $loop);
    })
        ->parameter('key', get('config.wyrimaps.battlenet.key')),
];
