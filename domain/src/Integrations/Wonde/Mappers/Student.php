<?php

declare(strict_types=1);

namespace Domain\Integrations\Wonde\Mappers;

use Domain\Data\Student as DataStudent;

class Student
{
    public function map(\stdClass $wondeStudent): DataStudent
    {
        return new DataStudent(
            $wondeStudent->id,
            $wondeStudent->forename,
            $wondeStudent->surname
        );
    }

    public function mapArray(array $wondeStudents): array
    {
        return array_map(function ($item) {
            return $this->map($item);
        }, $wondeStudents);
    }
}
