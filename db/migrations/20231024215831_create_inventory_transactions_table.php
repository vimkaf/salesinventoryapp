<?php

declare(strict_types=1);

use Phinx\Console\Command\Create;
use Phinx\Migration\AbstractMigration;

final class CreateInventoryTransactionsTable extends AbstractMigration
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
        $table = $this->table('inventory_transactions', ['id' => 'transaction_id']);
        $table->addColumn('inventory_id', 'integer');
        $table->addColumn('transaction_type', 'string');
        $table->addColumn('quantity', 'integer');
        $table->addColumn('previous_quantity', 'integer');
        $table->addColumn('transaction_date', 'date');
        $table->addColumn('employee_id', 'integer');
        $table->addColumn('remarks', 'text', ['null' => true]);
        $table->addColumn('reference_id', 'string');
        $table->Create();
    }
}
