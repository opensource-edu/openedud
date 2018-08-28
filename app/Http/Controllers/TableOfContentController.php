<?php

namespace App\Http\Controllers;


use App\Model\TableOfContent;
use Illuminate\Http\Request;

class TableOfContentController
{
    public function storage(Request $request)
    {
        $parentId = $request->get('parent_id', NULL);
//        $parent = TableOfContent::find($parentId);

        $tableOfContent = TableOfContent::create([
            'parent_id' => $parentId,
            'title' => $request->get('title')
        ]);

        return $tableOfContent;
    }
}