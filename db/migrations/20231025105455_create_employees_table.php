<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEmployeesTable extends AbstractMigration
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
        $table = $this->table('employees',['id'=>'employee_id']);
        $table->addColumn('first_name','text');
        $table->addColumn('last_name','text');
        $table->addColumn('email','string');
        $table->addColumn('phone_number','string');
        $table->addColumn('role','string');
        $table->addColumn('member_id','integer');
        $table->addColumn('trongate_user_id','integer');
        $table->create();
    }
}
