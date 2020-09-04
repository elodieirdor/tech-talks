<?php

use App\Talk;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create()->each(function (User $user) {
            for ($i = 0; $i < 3; $i++) {
                $user->talks()->save(factory(Talk::class)->make());
            }
        });
    }
}
