<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class EmployeeSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $table = $this->table('employees');

        $table->truncate();

        $data = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@alchidozcomputerventures',
                'phone_number' => '080CALLALCADMIN',
                'role' => 'admin',
                'member_id' => 0,
                'trongate_user_id' => 1
            ],
            [
                'first_name' => 'Manager',
                'last_name' => 'Manager',
                'email' => 'manager@alc',
                'phone_number' => '080CALLALCADMIN',
                'role' => 'manager',
                'member_id' => 0,
                'trongate_user_id' => 2
            ],
            [
                'first_name' => 'Sales',
                'last_name' => 'Sales',
                'email' => 'sales@alc',
                'phone_number' => '080CALLALCADMIN',
                'role' => 'sale',
                'member_id' => 0,
                'trongate_user_id' => 3
            ],
        ];

        $table->insert($data);

        $table->save();
    }
}
