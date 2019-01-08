<?php


class Request
{
    /** @var array */
    private $request;
    /** @var array */
    private $server;

    public function __construct(array $request, array $server)
    {
        $this->request = $request;
        $this->server = $server;
    }

    public function hasParameter(string $key): bool
    {
        return (isset($this->request[$key]) && $this->request[$key] !== '') ? true : false;
    }

    public function getParameter(string $key): string
    {
        return $this->request[$key];
    }

    public function receivedRequest(): bool
    {
        $errors = array_filter($this->request);
        if (!empty($errors)) {
            return true;
        }
        return false;
    }

    public function getURI(): string
    {
        return $this->server['REQUEST_URI'];
    }
}
