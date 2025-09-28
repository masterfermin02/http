<?php

namespace Tests\Unit;

use Http\HttpResponse;
use PHPUnit\Framework\TestCase;

class HttpResponseTest extends TestCase
{
    public function testSetStatusCode(): void
    {
        $response = new HttpResponse;

        $response->setStatusCode(404, 'Not Found');
        $this->assertEquals(
            $response->getHeaders()[0],
            'HTTP/1.1 404 Not Found'
        );
        $this->assertEquals($response->getStatusCode(), 404);

        $response->setStatusCode(555, 'Custom');
        $this->assertEquals($response->getHeaders()[0], 'HTTP/1.1 555 Custom');

        $response->setStatusCode(555, '');
        $this->assertEquals($response->getHeaders()[0], 'HTTP/1.1 555');
    }

    public function testAddHeader(): void
    {
        $response = new HttpResponse;

        $response->addHeader('name', 'value');
        $this->assertEquals(
            $response->getHeaders()[1],
            'name: value'
        );

        $response->addHeader('name2', 'value2');
        $this->assertEquals($response->getHeaders()[2], 'name2: value2');

    }

    public function testSetHeader(): void
    {
        $response = new HttpResponse;
        $response->addHeader('name', 'value');
        $response->addHeader('name2', 'value2');
        $response->setHeader('name2', 'value3');
        $this->assertEquals($response->getHeaders()[2], 'name2: value3');
    }

    public function testAddCookie(): void
    {
        $response = new HttpResponse;

        $response->addCookie(new MockCookie('mock1'));
        $this->assertEquals($response->getHeaders()[1], 'Set-Cookie: mock1');

        $response->addCookie(new MockCookie('mock2'));
        $this->assertEquals($response->getHeaders()[2], 'Set-Cookie: mock2');
    }

    public function testDeleteCookie(): void
    {
        $response = new HttpResponse;
        $response->addCookie(new MockCookie('mock1'));
        $response->deleteCookie(new MockCookie('mock1'));
        $this->assertEquals($response->getHeaders()[1], 'Set-Cookie: mock1  -1');
    }

    public function testSetContent(): void
    {
        $response = new HttpResponse;
        $response->setContent('test');
        $this->assertEquals($response->getContent(), 'test');
    }

    public function testRedirect(): void
    {
        $response = new HttpResponse;
        $response->redirect('http://test.com');
        $this->assertEquals($response->getHeaders(), [
            'HTTP/1.1 301 Moved Permanently',
            'Location: http://test.com'
        ]);
    }
}

class MockCookie implements \Http\Cookie
{
    private readonly string $name;
    private ?string $value = null;
    private ?int $maxAge = null;

    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setValue($value): void
    {
        $this->value = (string) $value;
    }

    public function setMaxAge($seconds): void
    {
        $this->maxAge = (int) $seconds;
    }

    public function setDomain(string $domain): void
    {
    }

    public function setPath(string $path): void
    {
    }

    public function setSecure(bool $secure): void
    {
    }

    public function setHttpOnly(bool $httpOnly): void
    {
    }

    public function getHeaderString(): string
    {
        return trim(implode(' ', [$this->name, $this->value, $this->maxAge]));
    }
}
