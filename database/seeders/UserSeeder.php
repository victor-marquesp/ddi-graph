<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    public function run() : void {
        
        $data = [
            [
                'name' => 'admin TEST', 
                'email' => 'admin.test@email.com', 
                'password' => Hash::make('@1234@5678'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('users')->insert($data);
    }

}
