<?php

use Phinx\Migration\AbstractMigration;

class CreateTableUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $articales=$this->table('users');
        $articales->addColumn('login','string')
                  ->addColumn('name','string')
                  ->addColumn('surname','string')
                  ->addColumn('age','integer')
                  ->addColumn('tel','string')
                  ->addColumn('address','string')
                  ->addColumn('created', 'timestamp')
                  ->addColumn('updated', 'timestamp', ['null' => true])
                  ->addColumn('admin','string')
                  ->addColumn('email','string')
                  ->addColumn('password', 'string', ['limit' => 40])
                  ->create();
    }
}
