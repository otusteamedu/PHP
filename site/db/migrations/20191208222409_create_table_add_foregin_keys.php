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
       ->addColumn('client_id','integer')
       ->addColumn('delivery_service_id','integer')
        ->addColumn('type_id','integer')
        ->save();


      $product=$this->table('product');
       $product

           ->addColumn('discount_product_id','integer')
        ->save();


        $delivery_service=$this->table('delivery_service');
        $delivery_service
        ->addColumn('discount_delivery_service_id','integer')
        ->save();



       $parser=$this->table('parser');
        $parser
        ->addColumn('product_id','integer')
        ->save();



      /*  $order
            ->addForeignKey('coupon_id','coupon','id',array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->addForeignKey('client_id','client','id',array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->addForeignKey('delivery_service_id','delivery_service','id',array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->addForeignKey('type_id','type','id',array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->save();
        $product
            ->addForeignKey('discount_product_id','discount_product','id',array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->save();
        $delivery_service
            ->addForeignKey('discount_delivery_service_id','discount_delivery_service','id',array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->save();
        $parser
            ->addForeignKey('product_id','product','id',array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->save();

        $orderProduct=$this->table('order_product');
        $orderProduct
            ->addForeignKey('order_id', 'order','id',array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->addForeignKey('product_id','product','id',array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
            ->save();*/
    }
}
