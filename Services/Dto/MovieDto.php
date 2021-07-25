<?php


namespace Services\Dto;

/**
 * Class MovieDto
 *
 * содержит поля из таблицы 'movie'
 *
 * @package Services\Dto
 */
class MovieDto extends AbstractDto
{
    public ?int $id;
    public ?string $name;
    public ?int $age_limit;
    public ?int $movie_genre_id;
}
