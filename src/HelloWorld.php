<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;

class HelloWorld
{
    private ResponseInterface $response;

    /**
     * HelloWorld constructor.
     */
    public function __construct(
        ResponseInterface $response
    ) {
        $this->response = $response;
    }

    /**
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __invoke(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write('<html><head></head><body>Hello, world!</body></html>');

        return $response;
    }
}
