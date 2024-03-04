<?php

namespace C3M1H1;

readonly class Like
{
    public function __construct(
        private User $user,
        private Video $video,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getVideo(): Video
    {
        return $this->video;
    }
}
