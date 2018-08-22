<?php
namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'discriminator',
        'title',
        'raw_name',
        'status',
        'mime_type',
        'size',
        'description'
    ];
}