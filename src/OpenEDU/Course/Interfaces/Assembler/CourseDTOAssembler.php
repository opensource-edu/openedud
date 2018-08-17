<?php
namespace OpenEDU\Course\Interfaces\Assembler;

use App\Model\Course;
use OpenEDU\Course\Interfaces\DTO\CourseDTO;

class CourseDTOAssembler
{
    public function toCourseDTO(Course $course)
    {


        $tocList = $f($course->tableOfContents());
        var_dump($tocList);die();

        return new CourseDTO($course->name, $tocList);
    }
}