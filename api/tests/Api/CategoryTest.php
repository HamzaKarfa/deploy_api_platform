<?php namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Category;

class CategoryTest extends ApiTestCase
{
    public function testGetCollection(): void
    {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createClient()->request('GET', 'https://cda2-devops-gael.simplon-roanne.com/categories');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/contexts/Book',
            '@id' => '/categories',
            '@type' => 'hydra:Collection',
            'hydra:view' => [
                '@id' => '/categories?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/categories?page=1',
            ],
        ]);

        // Because test fixtures are automatically loaded between each test, you can assert on them
        $this->assertCount(30, $response->toArray()['hydra:member']);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        // This generated JSON Schema is also used in the OpenAPI spec!
        $this->assertMatchesResourceCollectionJsonSchema(Book::class);
    }
    public function testCreateCategory(): void
    {
        $response = static::createClient()->request('POST', 'https://cda2-devops-gael.simplon-roanne.com/categories', ['json' => [
            'name' => 'The Handmaid\'s Tale',
            'author' => 'Margaret Atwood',
            'datePublished' => '1985-07-31T00:00:00+00:00',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/Book',
            '@type' => 'Book',
            'name' => 'The Handmaid\'s Tale',
            'author' => 'Margaret Atwood',
            'datePublished' => '1985-07-31T00:00:00+00:00',
        ]);
        $this->assertMatchesRegularExpression('~^/categories/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Book::class);
    }
    
}