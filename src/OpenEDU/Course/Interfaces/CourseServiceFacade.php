<?php
namespace OpenEDU\Course\Interfaces;

interface CourseServiceFacade
{
    public function findOneFlat($id);

    public function resources($courseId);
}