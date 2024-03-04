<?php

use C3M1H1\Channel;
use C3M1H1\ChannelObservers\UnsubscribeObserver;
use C3M1H1\ChannelSubscriber;
use C3M1H1\User;
use C3M1H1\Video;

use function Pest\Faker\fake;

it('can unsubscribe channel when upload video less than 1 minute', function () {
    $user = new User(fake()->name());
    $channel = new Channel(fake()->name());
    $observer = UnsubscribeObserver::class;

    // Subscribe to the channel
    $user->subscribe($channel, $observer);

    // Upload the video to the channel
    $video = new Video([
        'title' => fake()->name(),
        'description' => fake()->sentence(),
        'length' => fake()->numberBetween(0, 60),
    ]);
    $channel->upload($video);

    // Assert the user is unsubscribed from the channel
    $this->assertEmpty($channel->getSubscribers());

    // Assert the channel has no observers
    $this->assertEmpty($channel->getObservers());
});

it('cannot unsubscribe channel when upload video more than 1 minute', function () {
    $user = new User(fake()->name());
    $channel = new Channel(fake()->name());
    $observer = UnsubscribeObserver::class;

    // Subscribe to the channel
    $user->subscribe($channel, $observer);

    // Upload the video to the channel
    $video = new Video([
        'title' => fake()->name(),
        'description' => fake()->sentence(),
        'length' => fake()->numberBetween(61, 180),
    ]);
    $channel->upload($video);

    // Expect the user not to like the video
    $subscribers = $channel->getSubscribers();
    $subscriber = end($subscribers);

    // Assert the user is subscribed to the channel
    $this->assertCount(1, $subscribers);
    $this->assertInstanceOf(ChannelSubscriber::class, $subscriber);
    $this->assertEquals($subscriber->getChannel(), $channel);
    $this->assertEquals($subscriber->getUser(), $user);

    // Assert the channel has the observer
    $channelObservers = $channel->getObservers();

    $this->assertCount(1, $channelObservers);
    $this->assertInstanceOf($observer, end($channelObservers));
});
