<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description'];

    public function tableOfContents()
    {
        return $this->belongsToMany(TableOfContent::class);
//        return $this->hasMany(TableOfContent::class, 'course_id', 'id');
    }
}