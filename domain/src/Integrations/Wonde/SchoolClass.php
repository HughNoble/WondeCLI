<?php

declare(strict_types=1);

namespace Domain\Integrations\Wonde;

use Domain\Integrations\Wonde\Mappers\SchoolClass as MappersSchoolClass;
use Wonde\Endpoints\Classes;
use Wonde\Endpoints\Employees;

class SchoolClass
{
    private readonly Employees $wondeEmployeeClient;
    private readonly Classes $wondeClassClient;
    private readonly MappersSchoolClass $classMapper;

    public function __construct(
        Employees $wondeEmployeeClient,
        Classes $wondeClassClient,
        MappersSchoolClass $classMapper
    ) {
        $this->wondeEmployeeClient = $wondeEmployeeClient;
        $this->wondeClassClient = $wondeClassClient;
        $this->classMapper = $classMapper;
    }

    public function getClassesForEmployee($employeeId): array
    {
        $employee = $this->wondeEmployeeClient->get($employeeId, [ "classes" ]);

        $classes = [];

        foreach ($employee->classes->data as $class) {
            $classes[] = $this->classMapper->map(
                $this->wondeClassClient->get($class->id, [ "students" ])
            );
        }

        return $classes;
    }
}
