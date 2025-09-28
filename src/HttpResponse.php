<?php

namespace Http;

class HttpResponse implements Response
{
    private string $version = '1.1';
    private int $statusCode = 200;
    private string $statusText = 'OK';

    /**
     * @var array <string, string[]> $headers
     */
    private array $headers = [];

    /**
     * @var array <string, mixed> $cookies
     */
    private array $cookies = [];
    private ?string $content = null;

    /**
     * Standard HTTP status codes and texts.
     *
     * @var array<int, string>
     */
    private array $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Reserved for WebDAV advanced collections expired proposal',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /**
     * Sets the HTTP status code.
     *
     * @param  string  $statusText (optional)
     */
    public function setStatusCode(int $statusCode, ?string $statusText): void
    {
        if ($statusText === null
            && array_key_exists($statusCode, $this->statusTexts)
        ) {
            $statusText = $this->statusTexts[$statusCode];
        }

        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
    }

    /**
     * Returns the HTTP status code
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Adds a header with the given name.
     *
     * @param  string $name
     * @param  string $value
     */
    public function addHeader($name, $value): void
    {
        $this->headers[$name][] = (string) $value;
    }

    /**
     * Sets a new header for the given name.
     *
     * Replaces all headers with the same names.
     *
     * @param  string $name
     * @param  string $value
     */
    public function setHeader($name, $value): void
    {
        $this->headers[$name] = [
            (string) $value,
        ];
    }

    /**
     * Returns an array with the HTTP headers.
     */
    public function getHeaders(): array
    {
        return array_merge(
            $this->getRequestLineHeaders(),
            $this->getStandardHeaders(),
            $this->getCookieHeaders()
        );
    }

    /**
     * Adds a new cookie.
     */
    public function addCookie(Cookie $cookie): void
    {
        $this->cookies[$cookie->getName()] = $cookie;
    }

    /**
     * Deletes a cookie.
     */
    public function deleteCookie(Cookie $cookie): void
    {
        $cookie->setValue('');
        $cookie->setMaxAge(-1);
        $this->cookies[$cookie->getName()] = $cookie;
    }

    /**
     * Sets the body content.
     *
     * @param  string $content
     */
    public function setContent($content): void
    {
        $this->content = (string) $content;
    }

    /**
     * Returns the body content.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Sets the headers for a redirect.
     *
     * @param  string $url
     */
    public function redirect($url): void
    {
        $this->setHeader('Location', $url);
        $this->setStatusCode(301, null);
    }

    /**
     * Returns the request line header.
     *
     * E.g.: "HTTP/1.1 200 OK"
     *
     * @return string[]
     */
    private function getRequestLineHeaders(): array
    {
        $headers = [];

        $requestLine = sprintf(
            'HTTP/%s %s %s',
            $this->version,
            $this->statusCode,
            $this->statusText
        );

        $headers[] = trim($requestLine);

        return $headers;
    }

    /**
     * Returns all standard headers.
     *
     * @return string[]
     */
    private function getStandardHeaders(): array
    {
        $headers = [];

        foreach ($this->headers as $name => $values) {
            foreach ($values as $value) {
                $headers[] = "$name: $value";
            }
        }

        return $headers;
    }

    /**
     * Returns all cookie headers.
     *
     * @return string[]
     */
    private function getCookieHeaders(): array
    {
        $headers = [];

        foreach ($this->cookies as $cookie) {
            $headers[] = 'Set-Cookie: ' . $cookie->getHeaderString();
        }

        return $headers;
    }
}
