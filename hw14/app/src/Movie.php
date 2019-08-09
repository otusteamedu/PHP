<?php
/**
* Active record class for movie table
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys;

class Movie extends Abstraction\ActiveRecord
{
    protected $tablename = 'movie';

    protected $fillable = [
        'title',
        'year',
        'image_path',
        'description',
        'rating_id'
    ];

    protected $onload = [
        'title',
        'year'
    ];
}
