<?php

namespace C3M1H1\ChannelObservers;

use C3M1H1\ChannelSubscriber;

readonly class LikeVideoObserver implements ChannelObserver
{
    public function __construct(
        private ChannelSubscriber $subscriber
    ) {
    }

    public function update(): void
    {
        // If the video is more than 3 minutes long, like the video
        if ($this->threshold()) {
            $channel = $this->subscriber->getChannel();
            $video = $channel->getLatestVideo();

            $user = $this->subscriber->getUser();
            $user->like($video);

            // Show the user has liked the video
            echo "{$user->getName()} 對影片 $video->title 按讚\n";
        }
    }

    public function threshold(): bool
    {
        $channel = $this->subscriber->getChannel();

        // Get the latest video from the channel
        $latestVideo = $channel->getLatestVideo();

        return $latestVideo->length >= 180;
    }
}
