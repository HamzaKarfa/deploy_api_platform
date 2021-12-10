<?php

namespace App\Tests\Api\Class\Interfaces;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface RequestTestInterface
{
    public function getToken():string;
    public function httpClientRequest(string $pathUrl, string $method, array $bodyRequest, bool $needAuthToken = false):ResponseInterface;
}