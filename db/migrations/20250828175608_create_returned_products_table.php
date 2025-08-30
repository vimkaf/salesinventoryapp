<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateReturnedProductsTable extends AbstractMigration
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

        $table = $this->table('returned_products', [
            'id' => 'id'
        ]);

        $table->addColumn('employee_id', 'integer');
        $table->addColumn('sale_id', 'integer');
        $table->addColumn('product_id', 'integer');
        $table->addColumn('quantity_sold', 'integer');
        $table->addColumn('quantity_returned', 'integer');
        $table->addColumn('sale_price', 'double');
        $table->addColumn('return_price', 'double');
        $table->addColumn('date_time_returned', 'datetime');

        $table->create();
    }
}
