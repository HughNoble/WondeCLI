<?php

namespace Domain\Tests\Integrations\Wonde\Mappers;

use Domain\Data\Student as DataStudent;
use Domain\Integrations\Wonde\Mappers\SchoolClass;
use Domain\Integrations\Wonde\Mappers\Student;
use PHPUnit\Framework\TestCase;

class SchoolClassTest extends TestCase
{
    private object $studentRawData;
    private object $classRawData;

    private Student $studentMapper;
    private SchoolClass $testMapper;
    private DataStudent $studentData;

    public function __construct()
    {
        parent::__construct();

        $this->studentRawData = (object) [
            "some_student_data" => "some_value"
        ];

        $this->classRawData = (object) [
            "id" => "an_id",
            "name" => "test",
            "students" => (object) [
                "data" => [
                    $this->studentRawData
                ]
            ]
        ];

        $this->studentData = $this->getMockBuilder(DataStudent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->studentMapper = $this->getMockBuilder(Student::class)->getMock();
        $this->studentMapper->method('mapArray', [ $this->studentRawData ])
            ->willReturn([ $this->studentData ]);

        $this->testMapper = new SchoolClass($this->studentMapper);
    }

    public function testMappingData()
    {
        $mappedClass = $this->testMapper->map($this->classRawData);
        
        $this->assertEquals("an_id", $mappedClass->getId());
        $this->assertEquals("test", $mappedClass->getName());
        $this->assertEquals([ $this->studentData ], $mappedClass->getStudents());
    }
}
