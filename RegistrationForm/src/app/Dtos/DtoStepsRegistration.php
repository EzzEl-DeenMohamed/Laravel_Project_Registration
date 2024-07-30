<?php

namespace App\Dtos;
class DtoStepsRegistration
{
    private int $id;
    private string $data;
    private string $current_step;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): void
    {
        $this->data = $data;
    }

    public function getCurrentStep(): string
    {
        return $this->current_step;
    }

    public function setCurrentStep(string $current_step): void
    {
        $this->current_step = $current_step;
    }








}
