<?php

namespace Http;

interface Cookie
{
    public function getName(): string;
    public function setValue(string $value): void;
    public function setMaxAge(int $seconds): void;
    public function setDomain(string $domain): void;
    public function setPath(string $path): void;
    public function setSecure(bool $secure): void;
    public function setHttpOnly(bool $httpOnly): void;
    public function getHeaderString(): string;
}
