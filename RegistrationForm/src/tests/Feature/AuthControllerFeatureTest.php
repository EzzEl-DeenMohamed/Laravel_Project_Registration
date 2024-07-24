<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthControllerFeatureTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessGetLogin() : void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }


    public function testSuccessPostLogin()
    {
        $userData = [
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ];

        $response = $this->post('/login', $userData);

        $status = $response->getStatusCode();

        $this->assertTrue($status === 200 || $status === 302);

    }

    public function testRegistrationGetSuccess()
    {
        $response = $this->get('/registration');
        $response->assertStatus(200);
    }


    public function testRegistrationPostSuccess()
    {
        $requestData = [
            'full_name' => $this->faker->name,
            'user_name' => $this->faker->userName,
            'birthdate' => $this->faker->date,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'password' => $this->faker->password,
            'email' => $this->faker->email,
            'messageType' => 'phone'
        ];


        $response = $this->post('/registration', $requestData);
        $response->assertStatus(302);
    }


    public function testLogout()
    {
        $response = $this->get('/logout');
        $response->assertStatus(302);
    }


}
