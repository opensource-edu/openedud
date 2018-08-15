<?php
namespace Tests\App\Model;


use App\Model\TableOfContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableOfContentTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $tableOfContent = TableOfContent::create([
            'name' => 'Chapter 1',
            'children' => [
                [
                    'name' => 'Section 1'
                ]
            ]
        ]);
    }
}