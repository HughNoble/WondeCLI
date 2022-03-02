<?php

namespace Domain\Tests\Integrations\Wonde\Mappers;

use Domain\Integrations\Wonde\Mappers\Student;
use PHPUnit\Framework\TestCase;

class StudentTest extends TestCase
{
    private static string $id = "abc";
    private static string $forename = "Testy";
    private static string $surname = "McTest";

    private Student $studentMapper;

    public function __construct()
    {
        parent::__construct();
        $this->studentMapper = new Student;
    }

    public function testMapping()
    {
        $mappedStudent = $this->studentMapper->map(
            (object) [
                "id" => self::$id,
                "forename" => self::$forename,
                "surname" => self::$surname
            ]
        );

        $this->assertEquals(self::$id, $mappedStudent->getId());
        $this->assertEquals(self::$forename, $mappedStudent->getFirstName());
        $this->assertEquals(self::$surname, $mappedStudent->getLastName());
    }
}