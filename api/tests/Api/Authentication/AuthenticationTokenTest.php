<?php
namespace App\Tests\Api\Authentication;
use App\Tests\Api\Class\Abstract\AbstractRequestTest;

class AuthenticationTokenTest extends AbstractRequestTest
{
    public function testGetToken()
    {
            $authUserData = [
                'email'=>'hamza.karfa@gmail.com',
                'password'=>'123456'
            ];
            $response = $this->httpClientRequest('authentication_token', 'POST', $authUserData, false);
            
            $statusCode = $response->getStatusCode();
            // $statusCode = 200
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'
            $content = $response->toArray();

            $this->assertResponseIsSuccessful();
            $this->assertEquals($response->getStatusCode(), 200);
            $this->assertArrayHasKey('token', $content);
    }

}
