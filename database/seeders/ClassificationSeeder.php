<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassificationSeeder extends Seeder {
    
    public function run() : void {
        
        $data = [
            ['name' => 'Analgesic', 'description' => 'Relieves pain'],
            ['name' => 'Antidepressant', 'description' => 'Helps with mood disorders'],
            ['name' => 'Test Classification', 'description' => null],
        ];

        DB::table('classifications')->insert($data);
    }
}
