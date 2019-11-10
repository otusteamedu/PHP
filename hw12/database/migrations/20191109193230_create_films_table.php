<?php

use Phinx\Migration\AbstractMigration;

class CreateFilmsTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('films', ['primary_key' => 'id']);

        $table->addColumn('title', 'string');
        $table->addColumn('year', 'integer');
        $table->addIndex(['title', 'year']);

        $table->save();
    }

    public function down(): void
    {
        $this->table('films')->drop()->save();
    }
}
