<?php
declare(strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class Migration extends AbstractMigration
{
    public function change (): void
    {
        $table = $this->table('films');
        $table->addColumn('title', 'string', ['limit' => 100])
              ->addColumn('show_start_date', 'timestamp', ['null' => false])
              ->addColumn('length', 'smallinteger')
              ->create();
    }
}
