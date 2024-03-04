<?php

namespace C3M1H1;

use C3M1H1\ChannelObservers\ChannelObserver;

class Channel
{
    public array $videos = [];

    private array $observers = [];

    private array $subscribers = [];

    public function __construct(
        protected readonly string $name,
    ) {
    }

    public function addSubscriber(ChannelSubscriber $subscriber): void
    {
        // Subscribe the user
        $user = $subscriber->getUser();
        $subscribers = $this->getSubscribers();
        $subscribers[$user->getName()] = $subscriber;
        $this->setSubscribers($subscribers);

        // Register the observer
        $observer = $subscriber->getObserver();
        $this->register($observer);
    }

    public function getSubscribers(): array
    {
        return $this->subscribers;
    }

    public function setSubscribers(array $subscribers): void
    {
        $this->subscribers = $subscribers;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function register(ChannelObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function removeSubscriber(ChannelSubscriber $subscriber): void
    {
        $subscribers = $this->getSubscribers();

        // Unsubscribe the user
        $user = $subscriber->getUser();
        unset($subscribers[$user->getName()]);
        $this->setSubscribers($subscribers);

        // Unregister the observer
        $observer = $subscriber->getObserver();
        $this->unregister($observer);
    }

    public function unregister(ChannelObserver $observer): void
    {
        $observers = $this->getObservers();
        $key = array_search($observer, $observers);

        if ($key === false) {
            return;
        }

        unset($observers[$key]);
        $this->setObservers($observers);
    }

    public function getObservers(): array
    {
        return $this->observers;
    }

    public function setObservers(array $observers): void
    {
        $this->observers = $observers;
    }

    public function getLatestVideo(): ?Video
    {
        return end($this->videos) ?: null;
    }

    public function upload(Video $video): void
    {
        $video->setChannel($this);
        $this->videos[] = $video;

        // Show the video has been uploaded to the channel
        echo "頻道 $this->name 上架了一則新影片 $video->title\n";

        // Notify the observers
        $this->notify();
    }

    public function notify(): void
    {
        $observers = $this->getObservers();

        foreach ($observers as $observer) {
            $observer->update();
        }
    }
}
