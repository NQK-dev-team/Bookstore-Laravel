<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert admins
        DB::table('users')->insert([
            'id' => IdGenerator::generate(['table' => 'users', 'length' => 20, 'prefix' => 'U-A-']),
            'name' => 'Nghia Admin',
            'email' => 'nghia.duong272919136@hcmut.edu.vn',
            'password' => Hash::make('#Nghia123456789'),
            'address' => 'Ho Chi Minh City',
            'dob' => '2000-01-01',
            'phone' => '0123456789',
            'gender' => 'M',
            'image' => 'https://i.kym-cdn.com/photos/images/newsfeed/001/091/070/836.jpg',
            'is_admin' => true,
            'points' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Insert customers
        DB::table('users')->insert([
            'id' => IdGenerator::generate(['table' => 'users', 'length' => 20, 'prefix' => 'U-C-']),
            'name' => 'Nghia Customer',
            'email' => 'nghia147ty@gmail.com',
            'password' => Hash::make('#Nghia123456789'),
            'address' => 'Ho Chi Minh City',
            'dob' => '2000-01-01',
            'phone' => '1234567890',
            'gender' => 'M',
            'created_at' => now(),
            'updated_at' => now(),
            'point' => '27.31'
        ]);

        DB::table('users')->insert([
            'id' => IdGenerator::generate(['table' => 'users', 'length' => 20, 'prefix' => 'U-C-']),
            'name' => 'Attack helicopter Customer',
            'email' => 'khoa.luong.anh.nqk.test@gmail.com',
            'password' => Hash::make('#Khoa123456789'),
            'address' => 'Ho Chi Minh City',
            'dob' => '2000-01-01',
            'phone' => '0751234567',
            'gender' => 'O',
            'created_at' => now(),
            'updated_at' => now(),
            'point' => '27.87'
        ]);

        DB::table('users')->insert([
            'id' => IdGenerator::generate(['table' => 'users', 'length' => 20, 'prefix' => 'U-C-']),
            'name' => 'Female Customer',
            'email' => 'female.nqk.test@gmail.com',
            'password' => Hash::make('#Female123456789'),
            'address' => 'Ho Chi Minh City',
            'dob' => '2000-01-01',
            'phone' => '0712345678',
            'gender' => 'F',
            'created_at' => now(),
            'updated_at' => now(),
            'point' => '27.87'
        ]);
    }
}
