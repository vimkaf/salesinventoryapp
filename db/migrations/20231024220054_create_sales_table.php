<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSalesTable extends AbstractMigration
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
        $table = $this->table('sales', ['id' => 'sale_id']);
        $table->addColumn('sale_number', 'string');
        $table->addColumn('date_of_sale', 'date');
        $table->addColumn('total_price', 'double');
        $table->addColumn('customer_id', 'integer');
        $table->addColumn('warehouse_id', 'integer');
        $table->addColumn('amount_paid', 'double');
        $table->addColumn('status', 'string');
        $table->addColumn('discount', 'double');
        $table->addColumn('tax', 'double');
        $table->addColumn('grand_total', 'double');


        $table->create();
    }
}
