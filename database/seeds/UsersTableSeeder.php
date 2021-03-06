<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = factory(User::class)->times(50)->make();
        User::insert($user->makeVisible(['password','remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'lpf';
        $user->email = '1224312326@qq.com';
        $user->password = bcrypt('zaq12wsx');
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}
