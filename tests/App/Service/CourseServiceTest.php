<?php
namespace Tests\App\Service;


use App\Model\Resource;
use App\Service\CourseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $resource = Resource::create([
            'discriminator' => 'video',
            'title' => 'test',
            'status' => 'available',
            'mime_type' => 'video/mp4',
            'size' => 1,
            'description' => 'test'
        ]);

        $courseService = new CourseService();
        $course = $courseService->storage([
            'title' => 'Course1',
            'description' => 'test',
            'toc' => [
                [
                    'title' => 'Chapter 1',
                    'children' => [
                        [
                            'title' => 'Section 1',
                            'resource_id' => $resource->id
                        ]
                    ]
                ],
                [
                    'title' => 'Chapter 2',
                    'children' => [
                        [
                            'title' => 'Section 2'
                        ]
                    ]
                ]
            ]
        ]);

        var_dump($course->toArray());
    }
}