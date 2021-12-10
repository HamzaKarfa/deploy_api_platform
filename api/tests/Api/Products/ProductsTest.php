<?php
namespace App\Tests\Api\Products;

use App\Entity\SubCategory;
use App\Tests\Api\Class\Abstract\AbstractRequestTest;
class ProductsTest extends AbstractRequestTest
{
    public function testGetProductCollection(): void
    {
     
        $response = $this->httpClientRequest('products', 'GET');
        
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
        // Asserts that the returned JSON is a superset of this one
        $exampleResponseContains = [
            "id" => 1,
            "name" => "Product1",
            "price" => 1,
            "origin" => "France",
            "image" => null,
            "sub_categories" => "/sub_categories/1",
            "created_at" => "2021-11-23T11:24:29+00:00",
            "updated_at" => "2021-11-23T11:24:29+00:00",
            "createdAt" => "2021-11-23T11:24:29+00:00",
            "updatedAt" => "2021-11-23T11:24:29+00:00"
        ];
        $this->assertContains($exampleResponseContains, $response->toArray());
    }
    // public function testPostProduct(): void
    // {
    //     $subCategoryArray = [        
    //         "name" => "Product1",
    //         "price" => 1,
    //         "origin" => "France",
    //         "image" => null,
    //         "sub_categories" => [
    //             'name'=>'Fruits'
    //         ],
    //     ];
    //     $response = $this->httpClientRequest('products', 'POST', $subCategoryArray, true);
    //     $content = $response->toArray();
    //     $this->assertResponseIsSuccessful();
    //     $this->assertEquals($response->getStatusCode(), 201);
    //     dd($response->toArray());
    //     $exampleResponseContains = [
    //         "id" => 1,
    //         "name" => "Product1",
    //         "price" => 1,
    //         "origin" => "France",
    //         "image" => null,
    //         "sub_categories" => "/sub_categories/1",
    //         "created_at" => "2021-11-23T11:24:29+00:00",
    //         "updated_at" => "2021-11-23T11:24:29+00:00",
    //         "createdAt" => "2021-11-23T11:24:29+00:00",
    //         "updatedAt" => "2021-11-23T11:24:29+00:00"
    //     ];     
    //     foreach ($exampleResponseContains as $key => $value) {
    //         $this->assertArrayHasKey($key, $content);
    //         if ($key !== 'id' ) {
    //             $this->assertEquals( $value, $content[$key]);
    //         }
    //     }


    // }
    public function testGetOneCategory():void
    {
        $response = $this->httpClientRequest('products/1', 'GET');
        $content = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
        $exampleResponseContains = [
            "id" => 1,
            "name" => "Product1",
            "price" => 1,
            "origin" => "France",
            "sub_categories" => [
                'id' => 1,
                'name' => 'Fruits',
                'image' => 'Fruits.jpg',
                'category' => [
                    'id' => 1,
                    'name' => 'Fruits et légumes',
                    'image' => 'FL.jpg',
                    'description' => 'ON DONNE LA PRIMEUR AU GOÛT'
                ]
            ],
        ];     
        foreach ($exampleResponseContains as $key => $value) {
            $this->assertArrayHasKey($key, $content);
            if ($key !== 'id' || $key !== 'image') {
                $this->assertEquals( $value, $content[$key]);
            }
        }
    }

}
