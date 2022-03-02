<?php

declare(strict_types=1);

namespace Domain\Integrations\Wonde\Mappers;

use Domain\Data\SchoolClass as DataSchoolClass;

class SchoolClass
{
    private readonly Student $studentMapper;

    public function __construct(Student $studentMapper)
    {
        $this->studentMapper = $studentMapper;
    }

    public function map(\stdClass $wondeClass): DataSchoolClass
    {
        return new DataSchoolClass(
            $wondeClass->id,
            $wondeClass->name,
            $this->studentMapper->mapArray($wondeClass->students->data)
        );
    }
}
