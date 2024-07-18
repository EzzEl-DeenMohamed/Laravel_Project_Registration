<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class AuthManagerTest extends TestCase
{
    use RefreshDatabase;

    /** @test pass */
    public function user_can_register()
    {
        $response = $this->post('/registration', [
            'full_name' => 'John Doe',
            'user_name' => 'johndoe',
            'birthdate' => '1990-01-01',
            'phone' => '1234567890',
            'address' => '123 Street, City',
            'password' => '852741Ewq@',
            'email' => 'ezzeldeenm896@gmail.com',
        ]);

        $response->assertRedirect('/login')
            ->assertSessionHas('success', 'Registration Success, Login to access your app!!');
    }

    /** @test */
    public function user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'ezzeldeenm896@gmail.com',
            'password' => Hash::make('852741Ewq@'),
        ]);

        $response = $this->post('/login', [
            'email' => 'ezzeldeenm896@gmail.com',
            'password' => '852741Ewq@',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test failed */
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'ezzeldeenm896@gmail.com',
            'password' => Hash::make('852741Ewq@'),
        ]);

        $response = $this->post('/login', [
            'email' => 'ezzeldeenm896@gmail.com',
            'password' => '852741Ewq@',
        ]);

        $response->assertRedirect('/login')
            ->assertSessionHas('error', 'login details are invalid!!');
        $this->assertGuest();
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @test pass */
    public function registration_form_inserts_new_user()
    {
        $response = $this->post('/registration', [
            'full_name' => 'John Doe',
            'user_name' => 'johndoe',
            'birthdate' => '1990-01-01',
            'phone' => '1234567890',
            'address' => '123 Street, City',
            'password' => 'password',
            'email' => 'john@example.com',
        ]);

        $response->assertRedirect('/login')
            ->assertSessionHas('success', 'Registration Success, Login to access your app!!');

        $this->assertDatabaseHas('users', [
            'full_name' => 'John Doe',
            'user_name' => 'johndoe',
            'birthdate' => '1990-01-01',
            'phone' => '1234567890',
            'address' => '123 Street, City',
            'email' => 'john@example.com',
        ]);
    }
}
