<?php

namespace C3M1H1\ChannelObservers;

use C3M1H1\ChannelSubscriber;

readonly class UnsubscribeObserver implements ChannelObserver
{
    public function __construct(
        private ChannelSubscriber $subscriber
    ) {
    }

    public function update(): void
    {
        // If the video is less than 60 seconds long, unsubscribe the channel
        if ($this->threshold()) {
            $subscriber = $this->getSubscriber();
            $subscriber->unsubscribe();
        }
    }

    public function threshold(): bool
    {
        $channel = $this->subscriber->getChannel();

        // Get the latest video from the channel
        $latestVideo = $channel->getLatestVideo();

        return $latestVideo->length <= 60;
    }

    public function getSubscriber(): ChannelSubscriber
    {
        return $this->subscriber;
    }
}
