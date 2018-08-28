<?php
namespace App\Http\Controllers;


use App\Model\Course;
use App\Model\CourseFactory;
use App\Service\CourseService;
use Illuminate\Http\Request;

class CourseController
{
    /**
     * @var CourseService
     */
    private $courseService;

    /**
     * @var CourseFactory
     */
    private $courseFactory;

    public function __construct()
    {
        $this->courseService = new CourseService();
        $this->courseFactory = new CourseFactory();
    }

    public function storage(Request $request, $id = null)
    {
        $course = $request->json()->all();
        if ($id) {
            $course['id'] = (int)$id;
        }
        return $this->courseService->storage($course);
    }

    public function storageTableOfContent(Request $request, $courseId)
    {
        return $this->courseService->storageTableOfContent(
            $courseId,
            $request->get('id', NULL),
            $request->get('parent_id', NULL),
            $request->get('title')
        );
    }

    public function fetchList()
    {
        return Course::orderBy('id', 'desc')->paginate(20);
    }

    public function fetchOne($id)
    {
        return $this->courseFactory->findOne($id);
    }
}