<?php
namespace App\Service;


use App\Model\Course;
use App\Model\TableOfContent;

class CourseService
{
    public function storage($course)
    {
        $editing = false;
        if (isset($course['id'])) {
            $editing = true;
            $courseModel = Course::with('tableOfContents')
                ->find((int)$course['id']);
            $courseModel->title = $course['title'];
            $courseModel->description = $course['description'];
            $courseModel->save();
        } else {
            $courseModel = Course::create(
                [
                    'title' => $course['title'],
                    'description' => $course['description']
                ]
            );
        }

        if (isset($course['toc'])) {
            foreach ($course['toc'] as $toc) {
                $attached = isset($toc['id']);

                // if attached and build tree
                if ($attached) {
                    TableOfContent::rebuildTree(
                        [$toc]
                    );
                } else {
                    $tocModel = TableOfContent::create($toc);
                    $courseModel->tableOfContents()->attach($tocModel);
                }
            }
        }
        $id = $courseModel->id;

        return $courseModel
            ->with([
                'tableOfContents',
                'tableOfContents.resource'
            ])
            ->find($id);
    }

    function findUnattachedTOC($tocList)
    {

    }
}