<?php
namespace OpenEDU\Course\Domain\Model;


interface ResourceRepository
{
    /**
     * @return Resource[]
     */
    public function findTop10() : array;
}