<?php

use Phinx\Migration\AbstractMigration;

class CreateTableAddForeginKeys extends AbstractMigration
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
     * with the Table class.   //array('delete'=> 'CASCADE', 'update'=> 'CASCADE')   array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'')
     */
    public function change()
    {

        $order=$this->table('order');
        $order
        ->addColumn('coupon_id','integer')
       ->addForeignKey('coupon_id','coupon','id')
       ->addColumn('client_id','integer')
       ->addForeignKey('client_id','client','id')
       ->addColumn('delivery_service_id','integer')
        ->addForeignKey('delivery_service_id','delivery_service','id')
        ->addColumn('type_id','integer')
       ->addForeignKey('type_id','type','id')
        ->save();

      $product=$this->table('product');
       $product
       ->addColumn('order_id','integer')
       ->addForeignKey('order_id','order','id')
           ->addColumn('discount_product_id','integer')
           ->addForeignKey('discount_product_id','discount_product','id')
        ->save();

        $delivery_service=$this->table('delivery_service');
        $delivery_service
        ->addColumn('discount_delivery_service_id','integer')
        ->addForeignKey('discount_delivery_service_id','discount_delivery_service','id')
        ->save();

       $parser=$this->table('parser');
        $parser
        ->addColumn('product_id','integer')
        ->addForeignKey('product_id','product','id')
        ->save();

    }
}
