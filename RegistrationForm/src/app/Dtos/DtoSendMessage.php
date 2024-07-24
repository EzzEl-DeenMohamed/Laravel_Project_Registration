<?php

namespace App\Dtos;

class DtoSendMessage
{
    private string $messageType;
    private string $birthDate;
    private string $phone;
    private string $address;
    private string $email;
    private string $fullName;

    public function __construct(
        string $messageType,
        string $birthDate,
        string $phone,
        string $address,
        string $email,
        string $fullName

    ) {
        $this->messageType = $messageType;
        $this->birthDate = $birthDate;
        $this->phone = $phone;
        $this->address = $address;
        $this->email = $email;
        $this->fullName = $fullName;
    }

    public function getMessageType(): string
    {
        return $this->messageType;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }


}
