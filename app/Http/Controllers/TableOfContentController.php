<?php

namespace App\Http\Controllers;


use App\Model\TableOfContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableOfContentController
{
    public function storage(Request $request)
    {
        $parentId = $request->get('parent_id', NULL);

        $tableOfContent = TableOfContent::create([
            'parent_id' => $parentId,
            'title' => $request->get('title'),
            'resource_id' => $request->get('resource_id', 0)
        ]);

        return $tableOfContent;
    }

    public function batchStorage($parentId, Request $request)
    {
        $tableOfContents = [];
        DB::beginTransaction();

        $parent = TableOfContent::find($parentId);

        foreach($request->json()->all() as $tableOfContent) {
            $title = $tableOfContent['title'];
            $resourceId = isset($tableOfContent['resource_id']) ?
                $tableOfContent['resource_id'] : 0;

            $tableOfContent = TableOfContent::create([
                'title' => $title,
                'resource_id' => $resourceId
            ]);

            $parent->appendNode($tableOfContent);

            $tableOfContents[] = $tableOfContent;
        }
        DB::commit();

        return $tableOfContents;
    }

    public function attachResource($tableOfContentId, Request $request)
    {
        $tableOfContent = TableOfContent::find($tableOfContentId);

    }
}