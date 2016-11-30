<?php

use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Employee::class, 1000)->create()->each(function ($e) {
            if($e->id!=1)
            {
                $boss=App\Employee::where([
                    ['id', '!=', $e->id],
                    ['id', '<', 100],
                    ['boss_id', '>', 0],
                ])->orWhere('id', '=', 1)->inRandomOrder()->first();
                if($boss)
                {
                    $e->boss()->associate($boss);
                    $e->save();
                }
            }
        });
    }
}
