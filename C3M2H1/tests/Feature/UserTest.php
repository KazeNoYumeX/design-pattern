<?php

use C3M2H1\ChannelObservers\MoveForwardCommand;
use C3M2H1\ChannelObservers\UnsubscribeObserver;
use C3M2H1\Devices\Like;
use C3M2H1\Devices\Tank;
use C3M2H1\Devices\Telecom;
use C3M2H1\MainController;
use C3M2H1\User;

use function Pest\Faker\fake;

it('can subscribe to a channel with an observer', function () {
    echo get_class($this);

    $user = new User(fake()->name());
    $channel = new MainController(fake()->name());
    $observer = fake()->randomElement([
        MoveForwardCommand::class,
        UnsubscribeObserver::class,
    ]);

    $user->subscribe($channel, $observer);

    $userSubscriptions = $user->getSubscriptions()[$channel->getName()];
    $channelSubscriber = $channel->getSubscribers()[$user->getName()];
    $channelObservers = $channel->getObservers();
    $channelObserver = end($channelObservers);

    // Assert the user is subscribed to the channel
    $this->assertEquals($userSubscriptions, $channelSubscriber);
    $this->assertInstanceOf(Telecom::class, $userSubscriptions);
    $this->assertEquals($channelSubscriber->getChannel(), $channel);
    $this->assertEquals($channelSubscriber->getUser(), $user);

    // Assert the channel has the observer
    $this->assertInstanceOf($observer, $channelObserver);
});

it('can like video', function () {
    $user = new User(fake()->name());

    $video = new Tank([
        'title' => fake()->name(),
        'description' => fake()->sentence(),
        'length' => fake()->randomNumber(3),
    ]);

    $user->like($video);

    $userLike = end($user->likes);
    $videoLike = end($video->likes);

    // Assert the user likes the video
    $this->assertEquals($userLike, $videoLike);
    $this->assertInstanceOf(Like::class, $userLike);
    $this->assertEquals($userLike->getUser(), $user);
    $this->assertEquals($userLike->getVideo(), $video);
});
