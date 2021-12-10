<?php
namespace App\Tests\Api\Categories;

use App\Tests\Api\Class\Abstract\AbstractRequestTest;
class CategoriesTest extends AbstractRequestTest
{
    public function testGetCategoriesCollection(): void
    {
     
        $response = $this->httpClientRequest('categories', 'GET');
        
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
        // Asserts that the returned JSON is a superset of this one
        $exampleResponseContains = [
                "id" => 1,
                "name" => "Fruits et légumes",
                "image" => "FL.jpg",
                "description" => "ON DONNE LA PRIMEUR AU GOÛT",
                "subCategories" => [
                    0 => [
                        "id" => 1,
                        "name" => "Fruits",
                        "image" => "Fruits.jpg"
                    ],
                    1 => [
                        "id" => 2,
                        "name" => "Légumes",
                        "image" => "Legumes.jpg"
                    ],
                    2 => [
                        "id" => 3,
                        "name" => "Fruits et légumes exotiques",
                        "image" => "FL_exotiques.jpg"
                    ],
                    3 => [
                        "id" => 4,
                        "name" => "Herbes aromatiques et condiments",
                        "image" => "Herbes.jpg"
                    ]
                ]
            ];
        $this->assertContains($exampleResponseContains, $response->toArray());
    }
    public function testPostCategories(): void
    {
        $categoryArray = [        
            'name'=>'CategoryName',
            'image'=>'CategoryImage.jpg',
            'description'=>'CategoryDescription',
        ];
        $response = $this->httpClientRequest('categories', 'POST', $categoryArray, true);
        $content = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 201);

        $exampleResponseContains = [
            'id'=>20,
            "name" => "CategoryName",
            "image" => "CategoryImage.jpg",
            "description" => "CategoryDescription",
            "subCategories" => []
        ];     
        foreach ($exampleResponseContains as $key => $value) {
            $this->assertArrayHasKey($key, $content);
            if ($key !== 'id' ) {
                $this->assertEquals( $value, $content[$key]);
            }
        }


    }
    public function testGetOneCategory():void
    {
        $response = $this->httpClientRequest('categories/5', 'GET');
        $content = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
        $exampleResponseContains = [
            'id'=>5,
            "name" => "Poissonnerie",
            "image" => "POISS.jpg",
            "description" => "LA FRAÎCHEUR DÉBARQUE SUR VOS ÉTALS",
            "subCategories" =>[
                0=>[
                    "id"=>16,
                    "name"=>"Poisson entier et en filets",
                ],
                1=>[
                    "id"=>17,
                    "name"=>"Fruit de mer, crustasé et céphalopodes",
                ],
                2=>[
                    "id"=>18,
                    "name"=>"Le traiteur de la mer"]
            ]
        ];     
        foreach ($exampleResponseContains as $key => $value) {
            $this->assertArrayHasKey($key, $content);
            if ($key !== 'id' ) {
                $this->assertEquals( $value, $content[$key]);
            }
        }
    }

}
