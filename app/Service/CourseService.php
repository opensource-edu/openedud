<?php
namespace App\Service;


use App\Model\Course;
use App\Model\TableOfContent;

class CourseService
{
    public function storage($course)
    {
        $courseModel = Course::create(
            [
                'title' => $course['title']
            ]
        );

        foreach ($course['toc'] as $toc) {
            $tocModel = TableOfContent::create($toc);

            $courseModel->tableOfContents()->attach($tocModel);
        }
        $id = $courseModel->id;

        return $courseModel->with('tableOfContents')->find($id);
    }
}