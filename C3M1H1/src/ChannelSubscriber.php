<?php

namespace C3M1H1;

use C3M1H1\ChannelObservers\ChannelObserver;

readonly class ChannelSubscriber
{
    private ChannelObserver $observer;

    public function __construct(
        private User $user,
        private Channel $channel,
    ) {
    }

    public function unsubscribe(): void
    {
        $this->channel->removeSubscriber($this);
        $this->user->removeSubscription($this->channel);

        // Show the user has unsubscribed from the channel
        $user = $this->getUser();
        $channel = $this->getChannel();
        echo "{$user->getName()} 解除訂閱了 {$channel->getName()}\n";
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
    }

    public function getObserver(): ChannelObserver
    {
        return $this->observer;
    }

    public function setObserver(ChannelObserver $observer): void
    {
        $this->observer = $observer;
    }
}
