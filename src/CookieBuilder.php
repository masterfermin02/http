<?php

namespace Http;

class CookieBuilder
{
    private ?string $defaultDomain = null;
    private string $defaultPath = '/';
    private bool $defaultSecure = true;
    private bool $defaultHttpOnly = true;

    public function setDefaultDomain($domain): void
    {
        $this->defaultDomain = (string) $domain;
    }

    public function setDefaultPath($path): void
    {
        $this->defaultPath = (string) $path;
    }

    public function setDefaultSecure($secure): void
    {
        $this->defaultSecure = (bool) $secure;
    }

    public function setDefaultHttpOnly($httpOnly): void
    {
        $this->defaultHttpOnly = (bool) $httpOnly;
    }

    public function build($name, $value): \Http\HttpCookie
    {
        $cookie = new HttpCookie($name, $value);
        $cookie->setPath($this->defaultPath);
        $cookie->setSecure($this->defaultSecure);
        $cookie->setHttpOnly($this->defaultHttpOnly);

        if ($this->defaultDomain !== null) {
            $cookie->setDomain($this->defaultDomain);
        }

        return $cookie;
    }
}