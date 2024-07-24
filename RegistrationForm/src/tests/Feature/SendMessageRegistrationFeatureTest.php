<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendMessageRegistrationFeatureTest extends TestCase
{
    use withFaker;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $dtoRegister = [
            'full_name' => $this->faker->name,
            'user_name' => $this->faker->userName,
            'birthdate' => $this->faker->date,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'password' => $this->faker->password,
            'email' => $this->faker->email,
            'messageType' => 'phone'
        ];


        $response = $this->post('/send-message-registration',$dtoRegister);

        $response->assertStatus(200);
    }
}
