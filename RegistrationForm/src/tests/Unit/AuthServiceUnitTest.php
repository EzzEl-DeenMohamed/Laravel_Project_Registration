<?php

namespace Tests\Unit;

use App\Http\Controllers\SendMessageRegistrationController;
use Tests\TestCase;
use App\Services\AuthService;
use App\repository\UserRepository;
use App\Dtos\DtoLogin;
use App\Dtos\DtoRegister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mockery;

class AuthServiceUnitTest extends TestCase
{
    private $userRepositoryMock;
    private $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->authService = Mockery::mock(new AuthService($this->userRepositoryMock));
    }

    public function testLoginServicesReturnsFalseWhenNotAuthenticated()
    {
        Auth::shouldReceive('check')->andReturn(false);
        $result = $this->authService->loginServices();
        $this->assertFalse($result);
    }

    public function testLoginPostServiceReturnsTrueOnSuccessfulLogin()
    {
        $data = Mockery::mock(DtoLogin::class);
        $data->shouldReceive('getEmail')->andReturn('ezzeldeenm896@example.com');
        $data->shouldReceive('getPassword')->andReturn('852741Ewq@');

        Auth::shouldReceive('attempt')
            ->with(['email' => 'ezzeldeenm896@example.com', 'password' => '852741Ewq@'])
            ->andReturn(true);

        $result = $this->authService->loginPostService($data);
        $this->assertTrue($result);
    }


    public function testRegistrationPostServiceReturnsTrueOnSuccessfulRegistration()
    {
        $dtoRegister = Mockery::mock(DtoRegister::class);

        $this->userRepositoryMock
            ->shouldReceive('addUser')
            ->with($dtoRegister)
            ->andReturn(true);

        $sendMessageRegistrationControllerMock = Mockery::mock('overload:' . SendMessageRegistrationController::class);
        $sendMessageRegistrationControllerMock
            ->shouldReceive('send')
            ->with($dtoRegister)
            ->andReturnNull();

        $result = $this->authService->registrationPostService($dtoRegister);
        $this->assertTrue($result);
    }


    public function testLogout()
    {
        // Set expectations
        Session::shouldReceive('flush')->once();
        Auth::shouldReceive('logout')->once();

        // Execute the method
        $this->authService->logout();

        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
