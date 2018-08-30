<?php
namespace OpenEDU\Course\Infrastructure\Eloquent;


use OpenEDU\Course\Domain\Model\Resource;
use OpenEDU\Course\Domain\Model\ResourceRepository;

class ResourceRepositoryEloquent implements ResourceRepository
{

    /**
     * @return Resource
     */
    public function findTop10(): Resource
    {
        $resources = \App\Model\Resource::get()->limit(10)->orderBy('created_at', 'desc');
        return map(function($resource) {
            return new Resource($resource->id, $resource->title, null);
        }, $resources);
    }
}