<?php

namespace Http;

interface Request
{
    public function getParameter(string $key, mixed $defaultValue = null): ?string;
    public function getQueryParameter(string $key, mixed $defaultValue = null): ?string;
    public function getBodyParameter(string $key, ?string $defaultValue): ?string;
    public function getFile(string $key, mixed $defaultValue = null): ?string;
    public function getCookie(string $key, mixed $defaultValue = null): ?string;

    /** Returns all parameters as an associative array.
     * @return array<string, string>
     */
    public function getParameters(): array;

    /** Returns all query parameters as an associative array.
     * @return array<string, string>
     */
    public function getQueryParameters(): array;

    /** Returns all body parameters as an associative array.
     * @return array<string, string>
     */
    public function getBodyParameters(): array;

    public function getRawBody(): string;

    /** Returns all files as an associative array.
     * @return array<string, mixed>
     */
    public function getCookies(): array;

    /** Returns all files as an associative array.
     * @return array<string, mixed>
     */
    public function getFiles(): array;
    public function getUri(): string;
    public function getPath(): string|false;
    public function getMethod(): string;
    public function getHttpAccept(): string;
    public function getReferer(): string;
    public function getUserAgent(): string;
    public function getIpAddress(): string;
    public function isSecure(): bool;
    public function getQueryString(): string;
}
