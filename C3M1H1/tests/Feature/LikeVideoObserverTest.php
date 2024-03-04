<?php

use C3M1H1\Channel;
use C3M1H1\ChannelObservers\LikeVideoObserver;
use C3M1H1\Like;
use C3M1H1\User;
use C3M1H1\Video;

use function Pest\Faker\fake;

it('can like video if the video is more than 3 minutes long', function () {
    $user = new User(fake()->name());
    $channel = new Channel(fake()->name());
    $observer = LikeVideoObserver::class;

    $user->subscribe($channel, $observer);

    // Upload the video to the channel
    $video = new Video([
        'title' => fake()->name(),
        'description' => fake()->sentence(),
        'length' => fake()->numberBetween(180, PHP_INT_MAX),
    ]);
    $channel->upload($video);

    // Expect the user to like the video
    /** @var Like $like */
    $like = end($user->likes);
    $likeVideo = $like->getVideo();
    $likeUser = $like->getUser();

    // Assert the user likes the video
    $this->assertCount(1, $user->likes);
    $this->assertInstanceOf(Like::class, $like);
    $this->assertEquals($likeUser, $user);
    $this->assertEquals($likeVideo, $video);

    // Assert the channel has the video
    $this->assertEquals($likeVideo->getChannel(), $channel);
    $this->assertEquals($channel->getLatestVideo(), $video);
});

it('cannot like video if the video is less than 3 minutes long', function () {
    $user = new User(fake()->name());
    $channel = new Channel(fake()->name());
    $observer = LikeVideoObserver::class;

    $user->subscribe($channel, $observer);

    // Upload the video to the channel
    $video = new Video([
        'title' => fake()->name(),
        'description' => fake()->sentence(),
        'length' => fake()->numberBetween(0, 179),
    ]);
    $channel->upload($video);

    // Expect the user to not like the video
    $this->assertEmpty($user->likes);
});
