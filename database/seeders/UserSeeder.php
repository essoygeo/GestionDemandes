<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
           'nom'=>'jean',
           'email'=>'jean@gmail.com',
           'password'=>Hash::make('admin'),
           'role'=>'Admin'


       ]);
        User::create([
            'nom'=>'jeancomptable',
            'email'=>'jeancomptale@gmail.com',
            'password'=>Hash::make('admin'),
            'role'=>'Comptable'


        ]);
        User::create([
            'nom'=>'jeannecomptable',
            'email'=>'jeannecomptale@gmail.com',
            'password'=>Hash::make('admin'),
            'role'=>'Comptable'


        ]);

        User::create([
            'nom'=>'jean',
            'email'=>'jeanemploye@gmail.com',
            'password'=>Hash::make('admin'),
            'role'=>'Employe'


        ]);
    }
}
