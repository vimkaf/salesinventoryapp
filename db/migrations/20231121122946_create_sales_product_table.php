<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSalesProductTable extends AbstractMigration
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
        $table = $this->table('sales_product',['id'=>'sale_id']);
        $table = addColumn('sale_id','integer');
        $table = addColumn('product_id','integer');
        $table = addColumn('quantity_sold','integer');
        $table = addColumn('price','integer');
        $table = create();
    }
}
