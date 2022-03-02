<?php

declare(strict_types=1);

namespace Domain\Data;

class SchoolClass
{
    private readonly string $id;
    private readonly string $name;
    private readonly array $students;

    public function __construct(string $id, string $name, array $students)
    {
        $this->id = $id;
        $this->name = $name;
        $this->students = $students;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStudents(): array
    {
        return $this->students;
    }
}