<?php
namespace App\Model;


class CourseFactory
{
    public function findOne($id)
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