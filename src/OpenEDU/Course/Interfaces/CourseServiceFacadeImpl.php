<?php
namespace OpenEDU\Course\Interfaces;


use App\Model\Course;
use App\Model\CourseFactory;
use OpenEDU\Course\Interfaces\Assembler\CourseDTOAssembler;
use OpenEDU\Course\Interfaces\Assembler\TableOfContentDTOAssembler;
use OpenEDU\Course\Interfaces\DTO\CourseDTO;

class CourseServiceFacadeImpl implements CourseServiceFacade
{

    /**
     * @var CourseFactory
     */
    private $courseFactory;

    /**
     * @var CourseDTOAssembler
     */
    private $courseDTOAssembler;

    /**
     * @var TableOfContentDTOAssembler
     */
    private $tableOfContentDTOAssembler;

    public function __construct(CourseFactory $courseFactory)
    {
        $this->courseFactory = $courseFactory;
        $this->courseDTOAssembler = new CourseDTOAssembler();
        $this->tableOfContentDTOAssembler = new TableOfContentDTOAssembler();
    }

    public function findOneFlat($id)
    {
        $course = Course::with('tableOfContents')->find($id);

        $tocDTOList = $this
            ->tableOfContentDTOAssembler
            ->toDTOList($course->tableOfContents);

        return new CourseDTO($course->title, $course->description ?: '', $tocDTOList);
    }
}