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
        $courseUnsaved = [
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
        ];
        $course = $courseService->storage($courseUnsaved);

        $courseSaved = [
            'id' => 1,
            'title' => 'Course1 changed',
            'description' => 'test',
            'toc' => [
                [
                    'id' => 1,
                    'title' => 'Chapter 1 Changed',
                    'children' => [
                        [
                            'id' => 2,
                            'title' => 'Section 1',
                            'resource_id' => $resource->id
                        ],
                        [
                            'title' => 'Section 1.2',
                            'resource_id' => $resource->id
                        ]
                    ]
                ],
                [
                    'id' => 3,
                    'title' => 'Chapter 2',
                    'children' => [
                        [
                            'id' => 4,
                            'title' => 'Section 2'
                        ]
                    ]
                ],
                [
                    'title' => 'Chapter 3',
                    'children' => [
                        [
                            'title' => 'Section 3.1'
                        ]
                    ]
                ]
            ]
        ];

        $course = $courseService->storage($courseSaved);

        $chapter = $course->tableOfContents[0];
        $section = $chapter->children[1];

        $this->assertEquals('Course1 changed', $course->title);
        $this->assertEquals('Chapter 1 Changed', $chapter->title);
        $this->assertEquals('Section 1.2', $section->title);
        $this->assertEquals($resource->id, $section->resource->id);

        $chapter3 = $course->tableOfContents[2];
        $this->assertEquals('Chapter 3', $chapter3->title);
    }
}