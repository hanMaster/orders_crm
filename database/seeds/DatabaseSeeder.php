<?php

use Illuminate\Database\Seeder;
use App\LineStatus;
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
        $this->fillLineStatuses();
    }

    public function fillStatuses()
    {
        Status::create(['status' => 'creating', 'name' => 'Создается']);
        Status::create(['status' => 'editing', 'name' => 'Редактируется']);
        Status::create(['status' => 'new', 'name' => 'Новая заявка']);
        Status::create(['status' => 'approve_in_process', 'name' => 'На согласовании']);
        Status::create(['status' => 're_approve', 'name' => 'Для повторного согласования']);
        Status::create(['status' => 'approved', 'name' => 'Согласована']);
        Status::create(['status' => 'not_approved', 'name' => 'Не согласована']);
        Status::create(['status' => 'main_executor', 'name' => 'Принята к исполнению']);
        Status::create(['status' => 'executor', 'name' => 'В процессе исполнения']);
        Status::create(['status' => 'exec_done', 'name' => 'Исполнена']);
        Status::create(['status' => 'partial_done', 'name' => 'Частично исполнена']);
        Status::create(['status' => 'rejected', 'name' => 'Отменена']);
    }

    public function fillLineStatuses()
    {
        LineStatus::create(['status' => 'new', 'name' => 'Новая']);
        LineStatus::create(['status' => 'in_work', 'name' => 'В работе']);
        LineStatus::create(['status' => 'await_payment', 'name' => 'Ожидает оплаты']);
        LineStatus::create(['status' => 'invoice_approve', 'name' => 'Счет на согласовании']);
        LineStatus::create(['status' => 'ordered', 'name' => 'Заказано']);
        LineStatus::create(['status' => 'in_deliver', 'name' => 'В пути']);
        LineStatus::create(['status' => 'deliver_to_site', 'name' => 'Доставка на объект']);
        LineStatus::create(['status' => 'not_deliverable', 'name' => 'Поставка не возможна']);
        LineStatus::create(['status' => 'done', 'name' => 'Исполнено']);
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
                'name' => 'Григорашенко Игорь',
                'email' => '1@2.com',
                'email_verified_at' => now(),
                'password' => bcrypt('1qaz2wsx'), // password
                'remember_token' => Str::random(10),
                'phone' => '123456789',
                'role_id' => \Illuminate\Support\Facades\Config::get('role.starter')
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
        Ed::create(['name' => 'тн']);
        Ed::create(['name' => 'шт']);
        Ed::create(['name' => 'литр']);
        Ed::create(['name' => 'галлон']);
        Ed::create(['name' => 'куб']);
        Ed::create(['name' => 'кв. м']);
        Ed::create(['name' => 'м.п.']);
    }


}
