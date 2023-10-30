<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('products',['id'=>'product_id']);
        $table->addColumn('product_name','string');
        $table->addColumn('product_price','double');
        $table->addColumn('product_code','string');
        $table->addColumn('product_image','text');
        $table->addColumn('category_id','integer');
        $table->addColumn('brand','text');
        $table->addColumn('model','text');
        $table->addColumn('unit','string');
        $table->create();
    }
}
