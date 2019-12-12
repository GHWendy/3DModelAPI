<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_a_new_user_on_database(){
        $response = $this->get('/');
        $response->assertStatus(200);
          // Given
          $attributes = [
            'name' => 'Porta Taquitos',
            'price' => 26.50
        ];
        $productRequest = [
            'data' => [
                'type' => "products",
                'attributes' => $attributes
            ]
        ];

        // When
        $response = $this->json('POST', '/api/products', $productRequest);
        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);

        // Assert the response has the correct structure
        $response->assertJsonStructure([
                'type',
                'id',
                'attributes' => [
                    'name',
                    'price'
                ],
                'links' => ['self']

        ]);
        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'name' => 'Porta Taquitos',
            'price' => 26.50
        ]);

        $body = $response->decodeResponseJson();
        // Assert product is on the database
        $this->assertDatabaseHas(
            'products',
            [
                'id' => $body['id'],
                'name' =>  $body['attributes']['name'],
                'price' => $body['attributes']['price']
            ]
        );
    }
}
