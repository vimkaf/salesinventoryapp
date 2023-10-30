<?php

declare(strict_types=1);

use Phinx\Db\Action\AddIndex;
use Phinx\Migration\AbstractMigration;

final class CreateReceiptsTable extends AbstractMigration
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
        $table = $this->table('receipts',['id'=>'receipt_id']);
        $table->addColumn('receipt_number','string');
        $table->addColumn('invoice_number','string',['null'=>true]);
        $table->addColumn('date','date');
        $table->addColumn('amount','double');
        $table->addColumn('balance','double');
        $table->addColumn('customer_id','integer');
        $table->addColumn('payment_methode','string');
        $table->create();
    }
}
