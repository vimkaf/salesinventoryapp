<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class SettingsSeeder extends AbstractSeed
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
        $table = $this->table('settings');
        $data = [
            'discount' => 0, //Enable Discount
            'hold_sale' => 0, //enable hold sale,
            'tender_mode' => 'auto', //whether the cashier or sales amount tendered_should be auto or manual
            'receipt_multiple_printing' => 0, //allow cashier and sales to print more than once,
            'payment_methods' => 'POS, Cash, Bank Transfer'
        ];

        foreach ($data as $key => $val) {
            $table->insert([
                'setting_name' => $key,
                'setting_value' => $val
            ]);
        }

        $table->save();

    }
}
