<?php

use Phinx\Migration\AbstractMigration;

class CreateForeignKey extends AbstractMigration
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
        $client=$this->table('order');
        $client->addColumn('client_id', 'integer')
            ->addForeignKey('client_id','client','id')
            ->addColumn('coupon_id', 'integer')
            ->addForeignKey('coupon_id', 'coupon', 'id')
            ->save();

        $order_package = $this->table('order_package');
        $order_package->addColumn('order_id', 'integer')
            ->addForeignKey('order_id', 'order', 'id')
            ->addColumn('delivery_service_id', 'integer')
            ->addForeignKey('delivery_service_id', 'delivery_service', 'id')
            ->save();

        $order_product = $this->table('order_product');
        $order_product->addColumn('order_id', 'integer')
            ->addForeignKey('order_id', 'order', 'id')
            ->addColumn('product_id', 'integer')
            ->addForeignKey('product_id', 'product', 'id')
            ->save();

        $delivery_service = $this->table('delivery_service');
        $delivery_service->addColumn('delivery_discount_id', 'integer')
            ->addForeignKey('delivery_discount_id', 'delivery_service_discount', 'id')
            ->save();

        $product_discount = $this->table('product');
        $product_discount->addColumn('product_discount_id', 'integer')
            ->addForeignKey('product_discount_id', 'product_discount', 'id')
            ->save();
    }
}
