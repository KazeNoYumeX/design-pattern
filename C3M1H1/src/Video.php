<?php

namespace C3M1H1;

class Video
{
    public readonly string $title;

    public readonly string $description;

    public readonly int $length;

    public array $likes = [];

    private Channel $channel;

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

    public function getChannel(): Channel
    {
        return $this->channel;
    }

    public function setChannel(Channel $param): void
    {
        $this->channel = $param;
    }
}
