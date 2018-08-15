<?php
namespace Tests\App\Model;


use App\Model\Course;
use App\Model\TableOfContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseModelTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $course = Course::create([
            'title' => 'hello'
        ]);
        $toc = TableOfContent::create([
            [
                'name' => 'Chapter 1',
                'children' => [
                    [
                        'name' => 'Section 1'
                    ]
                ],
            ],
            [
                'name' => 'Chapter 2',
                'children' => [
                    [
                        'name' => 'Section 2'
                    ]
                ]
            ]
        ]);
        var_dump($toc->get()->toTree()[0]);

//        $r = $course->tableOfContents()->createMany(;
//        var_dump($r);
    }
}