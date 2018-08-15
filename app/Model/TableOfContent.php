<?php
namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class TableOfContent extends Model
{
    use NodeTrait;

    protected $fillable = ['name'];
}