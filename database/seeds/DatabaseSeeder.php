<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        if (App::environment('local')) {
            $this->call(ProductsTableSeeder::class);
            $this->call(ExpensesTableSeeder::class);
        }
    }
}
