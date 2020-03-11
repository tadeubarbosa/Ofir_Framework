<?php

namespace Ofir\Http;

class Url
{
    protected $url;

    protected $scheme;
    protected $host;
    protected $user;
    protected $pass;
    protected $path;
    protected $query;
    protected $fragment;

    public function __construct(?string $url)
    {
        $this->url = $url;
        if ($url!=null && $url!='/') {
            $parts = parse_url($url);
            $this->scheme   = $parts['scheme'] ?? null;
            $this->host     = $parts['host'] ?? null;
            $this->user     = $parts['user'] ?? null;
            $this->pass     = $parts['pass'] ?? null;
            $this->fragment = $parts['fragment'] ?? null;

            if (isset($parts['path']) && $parts['path']!=null) {
                $this->setPath($parts['path']);
            }

            if (isset($parts['query']) && $parts['query']!=null) {
                $this->setQuery($parts['query']);
            }
        }
    }

    public function setPath(?string $path): Url
    {
        $this->path = $path? rtrim($path, '/') . '/' : null;
        return $this;
    }

    public function setQuery(?string $query): Url
    {
        $response = [];
        if ($query!=null) {
            $query = explode('&', $query);
            foreach ($query as &$item) {
                $items = explode('=', $item);
                $name = $items[0];
                $value = $items[1];
                $response[$name] = $value;
            }
        }
        $this->query = $response;
        return $this;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(?string $host): Url
    {
        $this->host = $host;
        return $this;
    }

    public function __toString()
    {
        return $this->url;
    }

}
