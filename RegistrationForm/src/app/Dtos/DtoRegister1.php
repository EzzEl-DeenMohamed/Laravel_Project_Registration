<?php

namespace App\Dtos;

class DtoRegister1
{
    private string $full_name;
    private string $user_name;
    private string $birthdate;
    private string $address;


    public function __construct(string $full_name,
    string $user_name,
    string $birthdate,
    string $address
    )
    {
        $this->full_name = $full_name;
        $this->user_name = $user_name;
        $this->birthdate = $birthdate;
        $this->address = $address;

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


    public function getAddress(): string
    {
        return $this->address;
    }




}
