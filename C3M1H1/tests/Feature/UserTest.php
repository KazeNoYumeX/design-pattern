<?php

use C3M1H1\Channel;
use C3M1H1\ChannelObservers\LikeVideoObserver;
use C3M1H1\ChannelObservers\UnsubscribeObserver;
use C3M1H1\ChannelSubscriber;
use C3M1H1\Like;
use C3M1H1\User;
use C3M1H1\Video;

use function Pest\Faker\fake;

it('can subscribe to a channel with an observer', function () {
    echo get_class($this);

    $user = new User(fake()->name());
    $channel = new Channel(fake()->name());
    $observer = fake()->randomElement([
        LikeVideoObserver::class,
        UnsubscribeObserver::class,
    ]);

    $user->subscribe($channel, $observer);

    $userSubscriptions = $user->getSubscriptions()[$channel->getName()];
    $channelSubscriber = $channel->getSubscribers()[$user->getName()];
    $channelObservers = $channel->getObservers();
    $channelObserver = end($channelObservers);

    // Assert the user is subscribed to the channel
    $this->assertEquals($userSubscriptions, $channelSubscriber);
    $this->assertInstanceOf(ChannelSubscriber::class, $userSubscriptions);
    $this->assertEquals($channelSubscriber->getChannel(), $channel);
    $this->assertEquals($channelSubscriber->getUser(), $user);

    // Assert the channel has the observer
    $this->assertInstanceOf($observer, $channelObserver);
});

it('can like video', function () {
    $user = new User(fake()->name());

    $video = new Video([
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
