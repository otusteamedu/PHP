<?php

use Phinx\Migration\AbstractMigration;

class CreateTableDiscountDeliveryService extends AbstractMigration
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
    {    $discount_delivery_service=$this->table('discount_delivery_service');
        $discount_delivery_service->addColumn('discount_delivery_service_rub','integer',array('default'=>0))
        ->addColumn('discount_delivery_service_coefficient','float',array('default'=>0))
        ->create();

    }
}
