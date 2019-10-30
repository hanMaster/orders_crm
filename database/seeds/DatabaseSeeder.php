<?php

use Illuminate\Database\Seeder;
use App\Status;
use App\Role;
use App\User;
use App\Ed;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->fillStatuses();
        $this->fillRoles();
        $this->fillUsers();
        $this->fillEds();
    }

    public function fillStatuses()
    {
        Status::create(['status' => 'edit', 'name' => 'Создается']);
        Status::create(['status' => 'new', 'name' => 'Новая заявка']);
        Status::create(['status' => 'approve_in_process', 'name' => 'На согласовании']);
        Status::create(['status' => 're_approve', 'name' => 'Для повторного согласования']);
        Status::create(['status' => 'approved', 'name' => 'Согласована']);
        Status::create(['status' => 'not_approved', 'name' => 'Не согласована']);
        Status::create(['status' => 'main_executor', 'name' => 'Принята к исполнению']);
        Status::create(['status' => 'executor', 'name' => 'В процессе исполнения']);
        Status::create(['status' => 'exec_done', 'name' => 'Исполнена']);
        Status::create(['status' => 'confirmed', 'name' => 'Исполнение подтверждено']);
    }

    public function fillRoles()
    {
        Role::create(['name' => 'starter']);
        Role::create(['name' => 'approve']);
        Role::create(['name' => 'main_executor']);
        Role::create(['name' => 'executor']);
        Role::create(['name' => 'admin']);
    }

    public function fillUsers()
    {
        User::create([
            'name' => 'hanMaster',
            'email'=>'w54661c@gmail.com',
            'email_verified_at' => now(),
            'password'=>bcrypt('1qaz2wsx'),
            'phone' => '123456789',
            'role_id' => \Illuminate\Support\Facades\Config::get('role.admin')
        ]);
        User::create([
                'name' => 'Шестаков Владимир',
                'email' => '1@2.com',
                'email_verified_at' => now(),
                'password' => bcrypt('1qaz2wsx'), // password
                'remember_token' => Str::random(10),
                'phone' => '123456789',
                'role_id' => \Illuminate\Support\Facades\Config::get('role.starter')
        ]);
        User::create([
            'name' => 'Нагорный Роман',
            'email' => '2@2.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1qaz2wsx'), // password
            'remember_token' => Str::random(10),
            'phone' => '123456789',
            'role_id' => \Illuminate\Support\Facades\Config::get('role.approve')
        ]);
        User::create([
            'name' => 'Зубарев Алексей',
            'email' => '3@3.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1qaz2wsx'), // password
            'remember_token' => Str::random(10),
            'phone' => '123456789',
            'role_id' => \Illuminate\Support\Facades\Config::get('role.main_executor')
        ]);
        User::create([
            'name' => 'Слыщенко Алексей',
            'email' => '4@4.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1qaz2wsx'), // password
            'remember_token' => Str::random(10),
            'phone' => '123456789',
            'role_id' => \Illuminate\Support\Facades\Config::get('role.executor')
        ]);
        User::create([
            'name' => 'Кокорева Ольга',
            'email' => '3@4.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1qaz2wsx'), // password
            'remember_token' => Str::random(10),
            'phone' => '123456789',
            'role_id' => \Illuminate\Support\Facades\Config::get('role.executor')
        ]);
    }



    public function fillEds()
    {
        Ed::create(['name' => 'кг']);
        Ed::create(['name' => 'шт']);
        Ed::create(['name' => 'л']);
    }


}
