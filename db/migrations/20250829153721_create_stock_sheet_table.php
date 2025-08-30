<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateStockSheetTable extends AbstractMigration
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

        $table = $this->table('stock_sheets', ['id' => 'id']);

        $table->addColumn('date', 'date');
        $table->addColumn('product_code', 'string');
        $table->addColumn('product_name', 'text');
        $table->addColumn('opening_stock', 'integer');
        $table->addColumn('stock_in', 'integer');
        $table->addColumn('stock_out', 'integer');
        $table->addColumn('closing_stock', 'integer');
        $table->addColumn('remarks', 'text');

        $table->save();

    }
}
