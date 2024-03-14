<?php

namespace C3M2H1\Devices;

class Tank extends Device
{
    public readonly string $title;

    public readonly string $description;

    public readonly int $length;

    public array $likes = [];

    public function __construct(array $params)
    {
        $this->title = $params['title'];
        $this->description = $params['description'];
        $this->length = $params['length'];
    }

    public function addLikes(Like $like): void
    {
        $user = $like->getUser();
        $name = $user->getName();
        $this->likes[$name] = $like;
    }

    public function move(): void
    {
        // If the video is more than 3 minutes long, like the video
    }

    public function moveForward(): void
    {
        // If the video is more than 3 minutes long, like the video

    }

    public function moveBackward(): void
    {
        // If the video is less than 60 seconds long, unsubscribe the channel
    }
}
