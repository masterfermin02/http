<?php

namespace Http;

class HttpCookie implements Cookie
{
    private ?string $domain = null;
    private ?string $path = null;
    private ?int $maxAge = null;
    private ?bool $secure = null;
    private ?bool $httpOnly = null;

    public function __construct(private readonly string $name, private string $value)
    {
    }

    /**
     * Returns the cookie name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the cookie value.
     *
     * @param  string $value
     */
    public function setValue($value): void
    {
        $this->value = (string) $value;
    }

    /**
     * Sets the cookie max age in seconds.
     *
     * @param  integer $seconds
     */
    public function setMaxAge($seconds): void
    {
        $this->maxAge = (int) $seconds;
    }

    /**
     * Sets the cookie domain.
     *
     * @param  string $domain
     */
    public function setDomain($domain): void
    {
        $this->domain = (string) $domain;
    }

    /**
     * Sets the cookie path.
     *
     * @param  string $path
     */
    public function setPath($path): void
    {
        $this->path = (string) $path;
    }

    /**
     * Sets the cookie secure flag.
     *
     * @param  boolean $secure
     */
    public function setSecure($secure): void
    {
        $this->secure = (bool) $secure;
    }

    /**
     * Sets the cookie httpOnly flag.
     *
     * @param  boolean $httpOnly
     */
    public function setHttpOnly($httpOnly): void
    {
        $this->httpOnly = (bool) $httpOnly;
    }

    /**
     * Returns the cookie HTTP header string.
     */
    public function getHeaderString(): string
    {
        $parts = [
            $this->name . '=' . rawurlencode($this->value),
            $this->getMaxAgeString(),
            $this->getExpiresString(),
            $this->getDomainString(),
            $this->getPathString(),
            $this->getSecureString(),
            $this->getHttpOnlyString(),
        ];

        $filteredParts = array_filter($parts);

        return implode('; ', $filteredParts);
    }

    private function getMaxAgeString(): ?string
    {
        if ($this->maxAge !== null) {
            return 'Max-Age='. $this->maxAge;
        }
        return null;
    }

    private function getExpiresString(): ?string
    {
        if ($this->maxAge !== null) {
            return 'expires=' . gmdate(
                "D, d-M-Y H:i:s",
                time() + $this->maxAge
            ) . ' GMT';
        }
        return null;
    }

    private function getDomainString(): ?string
    {
        if ($this->domain !== null && $this->domain !== '' && $this->domain !== '0') {
            return "domain=$this->domain";
        }
        return null;
    }

    private function getPathString(): ?string
    {
        if ($this->path !== null && $this->path !== '' && $this->path !== '0') {
            return "path=$this->path";
        }
        return null;
    }

    private function getSecureString(): ?string
    {
        if ($this->secure === true) {
            return 'secure';
        }
        return null;
    }

    private function getHttpOnlyString(): ?string
    {
        if ($this->httpOnly === true) {
            return 'HttpOnly';
        }
        return null;
    }
}
