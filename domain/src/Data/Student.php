<?php

declare(strict_types=1);

namespace Domain\Data;

class Student
{
    private readonly string $id;
    private readonly string $firstName;
    private readonly string $lastName;

    public function __construct(string $id, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
