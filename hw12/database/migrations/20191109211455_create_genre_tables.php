<?php

use Phinx\Migration\AbstractMigration;

class CreateGenreTables extends AbstractMigration
{
    public function up(): void
    {
        $genreTable = $this->table('genres', ['primary_key' => 'id']);

        $genreTable->addColumn('title', 'string')
            ->addIndex(['title'], ['unique' => true])
            ->save();

        $refTable = $this->table('films_has_genres', [
            'id' => false,
            'primary_key' => ['film_id', 'genre_id'],
        ]);

        $refTable->addColumn('film_id', 'integer');
        $refTable->addColumn('genre_id', 'integer');
        $refTable->addForeignKey('film_id', 'films', 'id', [
            'update' => 'CASCADE',
            'delete' => 'CASCADE',
        ]);
        $refTable->addForeignKey('genre_id', 'genres', 'id', [
            'update' => 'CASCADE',
            'delete' => 'CASCADE',
        ]);
        $refTable->save();
    }

    public function down(): void
    {
        $this->table('genres')->drop()->save();
        $this->table('films_has_genres')->drop()->save();
    }
}
