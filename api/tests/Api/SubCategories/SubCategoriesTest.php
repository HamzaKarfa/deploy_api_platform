<?php
namespace App\Tests\Api\SubCategories;

use App\Entity\SubCategory;
use App\Tests\Api\Class\Abstract\AbstractRequestTest;
class SubCategoriesTest extends AbstractRequestTest
{
    public function testGetSubCategoriesCollection(): void
    {
     
        $response = $this->httpClientRequest('sub_categories', 'GET');
        
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
        // Asserts that the returned JSON is a superset of this one
        $exampleResponseContains = [
            "id" => 1,
            "name" => "Fruits",
            "image" => "Fruits.jpg",
            "category" => [
                "id" => 1,
                "name" => "Fruits et légumes",
                "image" => "FL.jpg",
                "description" => "ON DONNE LA PRIMEUR AU GOÛT",
            ]
        ];
        $this->assertContains($exampleResponseContains, $response->toArray());
    }
    public function testPostSubCategories(): void
    {
        $subCategoryArray = [        
            'name'=>'SubCategoryName',
            'image'=>'SubCategoryImage.jpg',
            'category'=>'/categories/5',
        ];
        $response = $this->httpClientRequest('sub_categories', 'POST', $subCategoryArray, true);
        $content = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 201);

        $exampleResponseContains = [
            'id'=>20,
            'name'=>'SubCategoryName',
            'image'=>'SubCategoryImage.jpg',
            'category'=>'/categories/5',
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
        $response = $this->httpClientRequest('sub_categories/1', 'GET');
        $content = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertEquals($response->getStatusCode(), 200);
        $exampleResponseContains = [
            "id" => 1,
            "name" => "Fruits",
            "image" => "Fruits.jpg",
            "category" => '/categories/1'
        ];     
        foreach ($exampleResponseContains as $key => $value) {
            $this->assertArrayHasKey($key, $content);
            if ($key !== 'id') {
                $this->assertEquals( $value, $content[$key]);
            }
        }
    }

}
