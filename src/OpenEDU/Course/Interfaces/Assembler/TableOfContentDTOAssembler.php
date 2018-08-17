<?php
namespace OpenEDU\Course\Interfaces\Assembler;

use OpenEDU\Course\Interfaces\DTO\TableOfContentDTO;

class TableOfContentDTOAssembler
{
    public function toDTOList($tableOfContents)
    {
        $tocList = [];

        foreach ($tableOfContents as $tableOfContent) {
            $tocList[] = new TableOfContentDTO($tableOfContent->name);

            if ($tableOfContent->children) {
                $tocList = array_merge(
                    $tocList,
                    $this->toDTOList($tableOfContent->children)
                );
            }
        }

        return $tocList;
    }
}