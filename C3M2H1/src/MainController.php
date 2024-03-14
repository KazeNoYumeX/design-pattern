<?php

namespace C3M2H1;

use C3M2H1\ChannelObservers\Command;
use C3M2H1\Devices\Tank;
use C3M2H1\Devices\Telecom;

class MainController
{
    private array $commands = [];
    public array $videos = [];

    private array $observers = [];

    private array $subscribers = [];

    public function __construct(
        protected readonly string $name,
    ) {
    }

    public function addSubscriber(Telecom $subscriber): void
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

    public function register(Command $observer): void
    {
        $this->observers[] = $observer;
    }

    public function removeSubscriber(Telecom $subscriber): void
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

    public function unregister(Command $observer): void
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

    public function getLatestVideo(): ?Tank
    {
        return end($this->videos) ?: null;
    }

    public function upload(Tank $video): void
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
