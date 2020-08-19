<?php
namespace Contracts;

use Models\Movies\Movie;

interface MovieStorageInterface
{
    public function insert(Movie $movie): Movie;
    public function select(int $id): Movie;
    public function update(Movie $movie): bool;
    public function delete(int $id): bool;
    public function getRangeMoviesByCreationDate(string $from, string $to, ?int $limit): array;
}