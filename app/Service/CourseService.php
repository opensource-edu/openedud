<?php
namespace App\Service;


use App\Model\Course;
use App\Model\TableOfContent;

class CourseService
{
    public function storage($course)
    {
        $courseModel = Course::create($course);

        foreach ($course['toc'] as $toc) {
            $tocModel = TableOfContent::create($toc);

            $courseModel->tableOfContents()->attach($tocModel);
        }

        return $courseModel->with('tableOfContents')->first();
    }
}