<?php

namespace App\Dtos;

class DtoRegister
{
    private string $full_name;
    private string $user_name;
    private string $birthdate;
    private string $phone;
    private string $address;
    private string $password;
    private string $email;
    private string $messageType;

    public function __construct(string $full_name,
    string $user_name,
    string $birthdate,
    string $phone,
    string $address,
    string $password,
    string $email,
    string $messageType
    )
    {
        $this->full_name = $full_name;
        $this->user_name = $user_name;
        $this->birthdate = $birthdate;
        $this->phone = $phone;
        $this->address = $address;
        $this->password = $password;
        $this->email = $email;
        $this->messageType = $messageType;
    }

    public function getFullName(): string
    {
        return $this->full_name;
    }

    public function getUserName(): string
    {
        return $this->user_name;
    }
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessageType(): string
    {
        return $this->messageType;
    }




}
