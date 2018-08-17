<?php
use Illuminate\Database\Seeder;
use App\Service\CourseService;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $course = [
            'title' => 'hello',
            'toc' => [
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
            ]
        ];
        $courseService = new CourseService();
        $course = $courseService->storage($course);
    }
}