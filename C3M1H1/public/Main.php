<?php

declare(strict_types=1);

use C3M1H1\Channel;
use C3M1H1\ChannelObservers\LikeVideoObserver;
use C3M1H1\ChannelObservers\UnsubscribeObserver;
use C3M1H1\User;
use C3M1H1\Video;

require_once dirname(__DIR__).'/vendor/autoload.php';

$pewdiepie = new Channel('PewDiePie');
$waterBallAcademy = new Channel('水球軟體學院');

$waterBall = new User('水球');
$fireBall = new User('火球');

$observer = LikeVideoObserver::class;
$waterBall->subscribe($waterBallAcademy, $observer);
$waterBall->subscribe($pewdiepie, $observer);

$observer = UnsubscribeObserver::class;
$fireBall->subscribe($waterBallAcademy, $observer);
$fireBall->subscribe($pewdiepie, $observer);

$waterBallAcademy->upload(new Video([
    'title' => 'C1M1S2',
    'description' => '這個世界正是物件導向的呢！',
    'length' => 4 * 60,
]));

$pewdiepie->upload(new Video([
    'title' => 'Hello guys',
    'description' => 'Clickbait',
    'length' => 30,
]));

$waterBallAcademy->upload(new Video([
    'title' => 'C1M1S3',
    'description' => '物件 vs. 類別',
    'length' => 60,
]));

$pewdiepie->upload(new Video([
    'title' => 'Minecraft',
    'description' => 'Let’s play Minecraft',
    'length' => 30 * 60,
]));
