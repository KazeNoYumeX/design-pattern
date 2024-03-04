<?php

namespace C3M1H1;

class User
{
    public array $likes = [];

    protected array $subscriptions = [];

    public function __construct(
        public readonly string $name,
    ) {
    }

    public function subscribe(Channel $channel, string $observer): void
    {
        $subscriber = new ChannelSubscriber($this, $channel);
        $subscriber->setObserver(new $observer($subscriber));

        $subscriptions = $this->getSubscriptions();
        $subscriptions[$channel->getName()] = $subscriber;
        $this->setSubscriptions($subscriptions);

        // Subscribe to the channel and register the observer
        $channel->addSubscriber($subscriber);

        // Show the user has subscribed to the channel
        echo "$this->name 訂閱了 {$channel->getName()}\n";
    }

    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    public function setSubscriptions(array $subscriptions): void
    {
        $this->subscriptions = $subscriptions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function removeSubscription(Channel $channel): void
    {
        $subscriptions = $this->getSubscriptions();
        unset($subscriptions[$channel->getName()]);
        $this->setSubscriptions($subscriptions);
    }

    public function like(Video $video): void
    {
        $like = new Like($this, $video);
        $this->likes[$video->title] = $like;
        $video->addLikes($like);
    }
}
