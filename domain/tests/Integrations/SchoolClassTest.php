<?php

namespace Domain\Tests\Integrations\Wonde;

use Domain\Data\SchoolClass as DataSchoolClass;
use Domain\Integrations\Wonde\Mappers\SchoolClass as SchoolClassMapper;
use Domain\Integrations\Wonde\SchoolClass;
use PHPUnit\Framework\TestCase;
use Wonde\Endpoints\Classes;
use Wonde\Endpoints\Employees;

class SchoolClassTest extends TestCase
{
    private static string $employeeId = "test-employee";
    private static string $class1Id = "class1";
    private static string $class2Id = "class2";
    
    private \stdClass $rawEmployeeData;
    private \stdClass $rawClass1Data;
    private \stdClass $rawClass2Data;
    private DataSchoolClass $class1;
    private DataSchoolClass $class2;

    private Employees $wondeEmployeeClient;
    private Classes $wondeClassClient;
    private SchoolClassMapper $classMapper;

    private SchoolClass $integration;

    public function __construct()
    {
        parent::__construct();

        $this->rawEmployeeData = (object) [
            "id" => self::$employeeId,
            "classes" => (object) [
                "data" => [
                    (object) [
                        "id" => self::$class1Id
                    ],
                    (object) [
                        "id" => self::$class2Id
                    ]
                ]
            ]
        ];

        $this->rawClass1Data = (object) [
            "id" => self::$class1Id
        ];

        $this->rawClass2Data = (object) [
            "id" => self::$class2Id
        ];

        $this->class1 = $this->getMockBuilder(DataSchoolClass::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->class2 = $this->getMockBuilder(DataSchoolClass::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->wondeEmployeeClient = $this->getMockBuilder(Employees::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->wondeClassClient = $this->getMockBuilder(Classes::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->classMapper = $this->getMockBuilder(SchoolClassMapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->integration = new SchoolClass(
            $this->wondeEmployeeClient,
            $this->wondeClassClient,
            $this->classMapper
        );
    }

    public function testGettingClassesForEmployeeId()
    {
        $this->wondeEmployeeClient->method("get", self::$employeeId, [ "attachments" => "classes" ])
            ->willReturn($this->rawEmployeeData);
        
        $this->wondeClassClient->method("get", self::$class1Id, [ "attachments" => "students" ])
            ->willReturn($this->rawClass1Data);
        
        $this->wondeClassClient->method("get", self::$class2Id, [ "attachments" => "students" ])
            ->willReturn($this->rawClass2Data);
        
        $this->classMapper->method("map", $this->rawClass1Data)
            ->willReturn($this->class1);
        
        $this->classMapper->method("map", $this->rawClass2Data)
            ->willReturn($this->class2);
        
        $this->assertEquals(
            [
                $this->class1,
                $this->class2,
            ],
            $this->integration->getClassesForEmployee(self::$employeeId)
        );
    }
}
