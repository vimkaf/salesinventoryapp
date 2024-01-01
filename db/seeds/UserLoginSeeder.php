<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserLoginSeeder extends AbstractSeed
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

        $table = $this->table('user_login');

        $table->truncate();

        $data = [
            [
                'employee_id' => 1,
                'role' => 1,
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_ARGON2I)
            ],
            [
                'employee_id' => 2,
                'role' => 2,
                'username' => 'manager',
                'password' => password_hash('manager', PASSWORD_ARGON2I)
            ],
            [
                'employee_id' => 3,
                'role' => 3,
                'username' => 'sales',
                'password' => password_hash('sales', PASSWORD_ARGON2I)
            ],
            [
                'employee_id' => 4,
                'role' => 4,
                'username' => 'cashier',
                'password' => password_hash('cashier', PASSWORD_ARGON2I)
            ],
        ];

        $table->insert($data);

        $table->save();

    }
}
