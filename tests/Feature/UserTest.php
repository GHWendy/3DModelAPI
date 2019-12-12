<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_a_new_user_on_database()
    {
        //$user = [factory(User::class)->make()]; //['data' => factory(User::class)->create()];
        $user = [
            "data" => [
                "attributes" => [
                    "name" => "Ale",
                    "email" => "alex1@a.com",
                    "password" => "1234"
                ],
            ]
        ]; //
        $response = $this->json('POST', '/api/v1/users/', $user);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'attributes' => [
                    'name',
                    'email',
                ]
            ]
        ]);

        $body = $response->decodeResponseJson();

        $response->assertJsonFragment(
            [
                'id' => $body['data']['id'],
                'attributes' => [
                    'name' => 'Ale',
                    'email' => 'alex1@a.com',
                ],
            ]
        );

        $this->assertDatabaseHas('users', [
            'id' => $body['data']['id'],
            'name' => 'Ale',
            'email' => 'alex1@a.com'
        ]);
    }

    public function test_show_all_users_on_database()
    {
        factory(User::class, 2)->create();
        // $user = factory(User::class)->create(['name' => 'alex', 'email' => 'alex2', 'id' => '2']);
        $response = $this->json('GET', '/api/v1/users/');
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    [
                        'id',
                        'attributes' => [
                            'name',
                            'email'
                        ]

                    ],
                ],
            ]
        );

        $body = $response->decodeResponseJson();

    }

    public function test_show_chose_user_on_database(){
        factory(User::class, 1)->create(['id' => '1']);
        // $user = factory(User::class)->create(['name' => 'alex', 'email' => 'alex2', 'id' => '2']);
        $response = $this->json('GET', '/api/v1/users/1');
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    [
                        'id',
                        'attributes' => [
                            'name',
                            'email'
                        ]

                    ]
                ]
            ]
        );

        $body = $response->decodeResponseJson();
    }

    public function test_login_when_parameters_are_correct()
    {
        $user = factory(User::class)->create([
            'email' => 'alex@data.com',
            'password' => '1234'
        ]);
        $response = $this->json('POST', '/api/login/', ['email' => 'alex1@data.com', 'password' => '1234']);

        $response = $this->actingAs($user)
            ->withSession(['email' => $user->email, 'password' => '1234']);
        // $response = $this->post('/login', [
        //     'email' => $user->email,
        //     'password' => '1234',
        // ]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_show_all_users_on_database_when_is_empty()
    {
        $response = $this->json('GET', '/api/v1/users/');
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'data' => []
            ]
        );
    }

    public function test_edit_my_info_when_im_login()
    {
        $user = factory(User::class)->create([
            'id' => '1',
            'email' => 'alex@data.com',
            'password' => '1234'
        ]);

        $response = $this->json('GET', '/api/login/', ['email' => 'alex@data.com', 'password' => '1234']);

        $response = $this->actingAs($user)
            ->withSession(['email' => $user->email, 'password' => '1234'])
            ->post('/api/v1/users/1', [

                "name" => "Ale",
                "email" => "alex1@a.com",
                "password" => "1234"

            ]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_edit_my_own_user_when_not_authenticated()
    {
        $user = factory(User::class)->create([
            'id' => '1',
            'email' => 'alex@data.com',
            'password' => '1234'
        ]);
        factory(User::class)->create();
        $response = $this->json('PUT', '/api/v1/users/1');
        $response->assertStatus(401);
        $response->assertJsonFragment(
            [
                "errors" => [
                    "code" => "ERROR-2",
                    "title" => "Unauthorized",
                    "detail" => "You need to authenticate"
                ]
            ]
        );
    }

    public function test_edit_other_user_who_not_exist()
    {
        //primero autenticar y luego intentar
        $user = factory(User::class)->create([
            'id' => '1',
            'email' => 'alex@data.com',
            'password' => '1234'
        ]);
        factory(User::class)->create(['id' => '2']);

        $response = $this->json('GET', '/api/login/', ['email' => 'alex@data.com', 'password' => '1234']);
        $response = $this->actingAs($user)
            ->withSession(['email' => $user->email, 'password' => '1234'])
            ->put('/api/v1/users/6', [

                "name" => "Ale",
                "email" => "alex1@a.com",
                "password" => "1234"

            ]);


        $this->assertAuthenticatedAs($user);


    }
}
