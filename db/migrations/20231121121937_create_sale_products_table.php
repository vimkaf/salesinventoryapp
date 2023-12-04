<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSaleProductsTable extends AbstractMigration
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
        $table  = $this->table('sale_products',['id'=>'id']);
        $table = addColumn('sale_id','integer');
        $table = addColumn('product_id','integer');
        $table = addcolumn('quantity_sold','integet');
        $table = addColunm('price','integer');
        $table = create();
    }
}
