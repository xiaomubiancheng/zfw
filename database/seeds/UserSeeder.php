<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清空数据表
        User::truncate();
        //添加模拟数据
        factory(User::class,100)->create();

        //规定id=1用户为admin
        User::where('id',1)->update(['username'=>'admin']);
    }
}
