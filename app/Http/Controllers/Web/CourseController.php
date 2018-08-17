<?php
namespace App\Http\Controllers\Web;


use App\Model\CourseFactory;
use OpenEDU\Course\Interfaces\CourseServiceFacade;

class CourseController
{
    /**
     * @var CourseFactory
     */
    private $courseFactory;

    /**
     * @var CourseServiceFacade
     */
    private $courseServiceFacade;

    public function __construct(CourseServiceFacade $courseServiceFacade)
    {
        $this->courseFactory = new CourseFactory();
        $this->courseServiceFacade = $courseServiceFacade;
    }

    public function detail($id)
    {
        return view("course_detail", [
            'course' => $this->courseServiceFacade->findOneFlat($id)
        ]);
    }
}