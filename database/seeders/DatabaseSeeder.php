<?php

namespace Database\Seeders;

use App\Models\admin;
use App\Models\products;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'CCTV',
            'gender' => 'Male',
            'email' => 'cctv@gmail.com',
            'password'=> '123456',
            'verify_code'=>'100000',
            'verify_time' => '1'
        ]);

        admin::create([
            'name' => 'guest',
            'password'=>Hash::make('123')
        ]);

        products::create([
            'p_name' => 'Spinach',
            'picture' => 'logos/Spinach.jpg',
            'description' => 'This is a Spinach',
            'mass' => '1000',
            'price'=>'5',
            'p_status'=>'Active'
        ]);

        products::create([
            'p_name' => 'Cabbage',
            'picture' => 'logos/Cabbage.webp',
            'description' => 'This is a Cabbage',
            'mass' => '1000',
            'price'=>'6',
            'p_status'=>'Active'
        ]);

        products::create([
            'p_name' => 'Pampkin',
            'picture' => 'logos/Pampkin.webp',
            'description' => 'This is a Pampkin',
            'mass' => '1000',
            'price'=>'8',
            'p_status'=>'Active'
        ]);
    }
}
