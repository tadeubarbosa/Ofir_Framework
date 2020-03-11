<?php

namespace Ofir\Http;

class Request
{
    /**
     * Header from server
     *
     * @var array
     */
    protected $headers = [];

    protected $host;
    protected $url;
    protected $uri;
    protected $method;
    protected $input;
    protected $router;

    public function __construct()
    {
        foreach ($_SERVER as $key => $value) {
            $key = strtolower($key);
            $dashedKey = str_replace('_', '-', $key);
            $this->headers[$dashedKey] = $value;
        }
        $this->host = $this->getHeader('http-host');
        $this->method = strtolower($this->getHeader('request-method'));
        $this->input = new Input($this);
        $this->method = strtolower($this->input->item('_method', $this->getHeader('request-method')));
        $this->router = new Router($this);
        $this->setUrl($this->getHeader('request-uri'));
        $this->setUri($this->getHeader('php-self'));
    }

    public function setUrl(?string $url): Request
    {
        $this->url = new Url($url);
        if ($this->url->getHost() == null) {
            $protocol = $this->isSecure()? 'https': 'http';
            $uri = $this->getHeader('request-uri');
            $url = "{$protocol}://{$this->host}{$uri}";
            $this->url = new Url($url);
        }
        return $this;
    }

    public function setUri(?string $uri): Request
    {
        $uri = str_replace('index.php', '', $uri);
        $uri = trim($uri, '/');
        $this->uri = $uri;
        return $this;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name, ?string $default = null): ?string
    {
        return $this->headers[strtolower($name)] ?? $default;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): Request
    {
        $this->method = strtolower($method);
        return $this;
    }

    public function getIp(): ?string
    {
        if ($this->getHeader('http-cf-connecting-ip') !== null) {
            return $this->getHeader('http-cf-connecting-ip');
        }

        if ($this->getHeader('http-x-forwarded-for') !== null) {
            return $this->getHeader('http-x-forwarded_for');
        }

        return $this->getHeader('remote-addr');
    }

    /**
     * Is over HTTPS
     *
     * @return boolean
     */
    public function isSecure(): bool
    {
        return $this->getHeader('http-x-forwarded-proto') === 'https' || $this->getHeader('https') !== null || $this->getHeader('server-port') === 443;
    }

    /**
     * Get HTTP REFERER
     *
     * @return string|null
     */
    public function getReferer(): ?string
    {
        return $this->getHeader('http-referer');
    }

    /**
     * Get input class
     * @return Input
     */
    public function getInput(): Input
    {
        return $this->input;
    }

}
