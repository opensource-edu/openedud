<?php
namespace App\Http\Controllers;


use App\Model\Course;
use App\Model\TableOfContent;
use App\Service\CourseService;
use Illuminate\Http\Request;

class CourseController
{
    /**
     * @var CourseService
     */
    private $courseService;

    public function __construct()
    {
        $this->courseService = new CourseService();
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
        $course = Course::find($id)->with('tableOfContents')->first();

        $tableOfContents = array_map(
            function ($content) {
                return TableOfContent::withDepth()
                    ->descendantsAndSelf($content['id'])
                    ->toTree();
            },
            $course->tableOfContents->toArray()
        );
        $courseJSON = $course->toArray();
        $courseJSON['table_of_contents'] = $tableOfContents;
        return $courseJSON;
    }
}