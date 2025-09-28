<?php

namespace Http;

interface Response
{
    public function setStatusCode(int $statusCode, ?string $statusText): void;
    public function getStatusCode(): int;
    public function addHeader(string $name, mixed $value): void;
    public function setHeader(string $name, mixed $value): void;
    /**
     * Returns an array with the HTTP headers.
     *
     * The first element is always the request line, e.g.:
     * "HTTP/1.1 200 OK"
     *
     * Following elements are the headers, e.g.:
     * "Content-Type: text/html; charset=UTF-8"
     * "Set-Cookie: name=value; Path=/; HttpOnly"
     *
     * @return string[]
     */
    public function getHeaders(): array;
    public function addCookie(Cookie $cookie): void;
    public function deleteCookie(Cookie $cookie): void;
    public function setContent(string $content): void;
    public function getContent(): string;
    public function redirect(string $url): void;
}
