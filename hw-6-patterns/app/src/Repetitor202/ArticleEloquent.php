<?php


namespace Repetitor202;


use Illuminate\Database\Eloquent\Model as Eloquent;

class ArticleEloquent extends Eloquent
{
    protected $table = 'articles';

    protected $fillable = [
        'category',
        'format',
        'name',
        'body',
    ];
}