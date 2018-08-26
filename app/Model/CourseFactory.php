<?php
namespace App\Model;


class CourseFactory
{
    public function findOne($id)
    {
        $course = Course::with([
            'tableOfContents',
            'tableOfContents.resource'
            ])
            ->find($id);

        $tableOfContents = array_map(
            function ($content) {
                $toc = TableOfContent::withDepth()
                    ->with('resource')
                    ->descendantsAndSelf($content['id'])
                    ->toTree();
                return $toc[0];
            },
            $course->tableOfContents->toArray()
        );
        $courseJSON = $course->toArray();
        $courseJSON['table_of_contents'] = $tableOfContents;
        return $courseJSON;
    }
}