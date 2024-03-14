<?php

namespace C3M2H1;

use C3M2H1\Devices\Like;
use C3M2H1\Devices\Tank;
use C3M2H1\Devices\Telecom;

class User
{
    public array $likes = [];

    protected array $subscriptions = [];

    public function __construct(
        public readonly string $name,
    ) {
    }

    public function subscribe(MainController $channel, string $observer): void
    {
        $subscriber = new Telecom($this, $channel);
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

    public function removeSubscription(MainController $channel): void
    {
        $subscriptions = $this->getSubscriptions();
        unset($subscriptions[$channel->getName()]);
        $this->setSubscriptions($subscriptions);
    }

    public function like(Tank $video): void
    {
        $like = new Like($this, $video);
        $this->likes[$video->title] = $like;
        $video->addLikes($like);
    }
}
