<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTransferLogTable extends AbstractMigration
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
        $table = $this->table('transfer_log',['id'=>'transfer_id']);
        $table->addColumn('product_id','integer');
        $table->addColumn('source_warehouse_id','integer');
        $table->addColumn('destination_warehouse_id','integer');
        $table->addColumn('quantity_transfered','integer');
        $table->addColumn('transfer_date','date');
        $table->addColumn('employee_id','integer');
        $table->create();
    }
}
