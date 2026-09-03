<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrugSeeder extends Seeder {

    public function run() : void {
        
        $data = [
            [
                'name' => 'Ibuprofen',
                'description' => 'Treats inflamation',
                'classification_id' => 1,
            ],
            [
                'name' => 'Paracetamol',
                'description' => null,
                'classification_id' => 1
            ],
            [
                'name' => 'Test',
                'description' => 'test description',
                'classification_id' => 3
            ]
        ];

        DB::table('drugs')->insert($data);
    }
}
