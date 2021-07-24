<?php


namespace Services\Dao\DataMapper\Movie;


use Services\Dto\MovieDto;
use Services\Traits\HasObjectTools;


/**
 * Class Movie
 * @package Services\Dao\DataMapper\Movie
 */
class Movie
{
    use HasObjectTools;

    private ?int $id = null;
    private ?string $name = null;
    private ?int $ageLimit = null;
    private ?string $genre = null;
    private ?int $movieGenreId = null;

    /**
     * Movie constructor.
     * @param MovieDto|null $movie
     */
    public function __construct(MovieDto $movie = null)
    {
        if (is_null($movie)){
            return;
        }
        $this->id = $movie->id;
        $this->name = $movie->name;
        $this->ageLimit = $movie->age_limit;
        $this->genre = $movie->genre;
        $this->movieGenreId = $movie->movie_genre_id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Movie
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Movie
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAgeLimit(): ?int
    {
        return $this->ageLimit;
    }

    /**
     * @param int|null $ageLimit
     * @return Movie
     */
    public function setAgeLimit(?int $ageLimit): self
    {
        $this->ageLimit = $ageLimit;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGenre(): ?string
    {
        return $this->genre;
    }

    /**
     * @param string|null $genre
     * @return Movie
     */
    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMovieGenreId(): ?int
    {
        return $this->movieGenreId;
    }

    /**
     * @param int|null $movieGenreId
     * @return Movie
     */
    public function setMovieGenreId(?int $movieGenreId): self
    {
        $this->movieGenreId = $movieGenreId;
        return $this;
    }

    /**
     * Набор лейблов для свойств объекта
     *
     * @return string[]
     */
    public static function attributeLabels(): array
    {
        return [
            'id' => 'Код фильма',
            'name' => 'Наименование фильма',
            'ageLimit' => 'Возрастное ограничение',
            'genre' => 'Жанр',
        ];
    }

}
