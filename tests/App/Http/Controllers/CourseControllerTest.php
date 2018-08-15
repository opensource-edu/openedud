<?php
namespace Tests\App\Http\Controllers;


use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    public function testStorage()
    {
        $response = $this->json(
            'POST',
            '/api/course',
            [
                'name' => 'Course 1',
                'toc' => [
                    [
                        'name' => 'Chapter 1'
                    ]
                ]
            ]
        );
        $this->assertTrue($response->isOk());
    }
}