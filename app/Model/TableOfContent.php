<?php
namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class TableOfContent extends Model
{
    use NodeTrait;

    protected $fillable = ['title', 'resource_id'];

    public function resource()
    {
        return $this->hasOne(Resource::class, 'id', 'resource_id');
    }
}