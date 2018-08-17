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

    public function storage(Request $request)
    {
        return $this->courseService->storage($request->json()->all());
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