<?php

namespace Ofir\Http;

class Input
{
    protected $get = [];
    protected $post = [];
    protected $file = [];

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->parseInputs();
    }

    public function parseInputs()
    {
        if (count($_GET)) {
            $this->get = $_GET;
        }

        if (count($_POST)) {
            $this->post = $_POST;
        }

        if (count($_FILES)) {
            $this->files = $_FILES;
        }
    }

    public function item(?string $name, ?string $default = null)
    {
        $item = $default;
        if ($this->get($name) !== null) {
            $item = $this->get($name);
        }
        if ($this->post($name) !== null) {
            $item = $this->post($name);
        }
        if ($this->file($name) !== null) {
            $item = $this->file($name);
        }
        return $item;
    }

    public function get(?string $name, ?string $default = null)
    {
        return $this->get[$name] ?? $default;
    }

    public function post(?string $name, ?string $default = null)
    {
        return $this->post[$name] ?? $default;
    }

    public function file(?string $name, ?string $default = null)
    {
        return $this->files[$name] ?? $default;
    }

    public function gets(): ?array
    {
        return $this->get;
    }

    public function posts(): ?array
    {
        return $this->post;
    }

    public function files(): ?array
    {
        return $this->files;
    }

}
