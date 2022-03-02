<?php

namespace App\Console\Commands;

use Domain\Data\Student;
use Domain\Integrations\Wonde\SchoolClass;
use Illuminate\Console\Command;

class ShowClasses extends Command
{
    private SchoolClass $wondeClassIntegration;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'classes {employee-id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List classes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SchoolClass $wondeClassIntegration)
    {
        $this->wondeClassIntegration = $wondeClassIntegration;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $employeeId = $this->argument("employee-id") ?: env("WONDE_EMPLOYEE_ID");

        $classes = $this->wondeClassIntegration->getClassesForEmployee($employeeId);

        foreach ($classes as $class) {
            $this->line(sprintf("Class: %s", $class->getName()));

            $this->table(
                [ "Surname", "Forename" ],
                array_map(function (Student $student) {
                    return [
                        $student->getLastName(),
                        $student->getFirstName()
                    ];
                }, $class->getStudents())
            );

            $this->newLine();
        }

        return 0;
    }
}
