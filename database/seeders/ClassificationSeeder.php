<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassificationSeeder extends Seeder {
    
    public function run() : void {
        
        $data = [
            [
                'name' => 'Analgésicos',
                'description' => 'Medicamentos utilizados principalmente para o alívio da dor.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Anti-inflamatórios',
                'description' => 'Medicamentos utilizados para reduzir processos inflamatórios.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Antibióticos',
                'description' => 'Medicamentos utilizados no tratamento de infecções bacterianas.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Anticoagulantes',
                'description' => 'Medicamentos que reduzem a capacidade de coagulação do sangue.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Anti-hipertensivos',
                'description' => 'Medicamentos utilizados para o controle da pressão arterial.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Antidepressivos',
                'description' => 'Medicamentos utilizados principalmente no tratamento da depressão.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Test class',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('classifications')->insert($data);
    }
}
