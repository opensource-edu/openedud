<?php
namespace Tests\OpenEDU\Course\Interfaces;


use App\Model\CourseFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenEDU\Course\Interfaces\CourseServiceFacadeImpl;
use Tests\TestCase;

class CourseServiceFacadeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->seed(\CourseSeeder::class);
    }

    public function testFindOneFlat()
    {
        $courseServiceFacade = new CourseServiceFacadeImpl(
            new CourseFactory()
        );

        $courseDTO = $courseServiceFacade->findOneFlat(1);

        $this->assertEquals(4, count($courseDTO->tableOfContents()));
    }
}