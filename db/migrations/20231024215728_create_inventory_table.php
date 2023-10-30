<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateInventoryTable extends AbstractMigration
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
        $table = $this->table('inventory',['id'=>'inventory_id']);
        $table->addColumn('product_id','integer');
        $table->addColumn('warehouse_id','integer');
        $table->addColumn('quantity_on_hand','integer');
        $table->addColumn('reorder_level','integer');
        $table->create();
    }
}
