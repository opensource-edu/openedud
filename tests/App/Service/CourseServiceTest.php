<?php
namespace Tests\App\Service;


use App\Service\CourseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $courseService = new CourseService();
        $courseService->storage([
            'title' => 'Course1',
            'toc' => [
                [
                    'name' => 'Chapter 1',
                    'children' => [
                        [
                            'name' => 'Section 1'
                        ]
                    ]
                ],
                [
                    'name' => 'Chapter 2',
                    'children' => [
                        [
                            'name' => 'Section 2'
                        ]
                    ]
                ]
            ]
        ]);
    }
}