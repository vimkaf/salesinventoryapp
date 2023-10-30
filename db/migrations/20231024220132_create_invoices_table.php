<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateInvoicesTable extends AbstractMigration
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
        $table = $this->table('invoices',['id'=>'invoice_id']);
        $table->addColumn('invoice_number','string'); 
        $table->addColumn('sale_id','integer');
        $table->addColumn('invoice_amount','double');
        $table->addColumn('customer_id','integer');
        $table->addColumn('date','date');
        $table->create();
    }
}
