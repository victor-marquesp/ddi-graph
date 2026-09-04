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
            ],
            [
                'name' => 'Anti-inflamatórios',
                'description' => 'Medicamentos utilizados para reduzir processos inflamatórios.',
            ],
            [
                'name' => 'Antibióticos',
                'description' => 'Medicamentos utilizados no tratamento de infecções bacterianas.',
            ],
            [
                'name' => 'Anticoagulantes',
                'description' => 'Medicamentos que reduzem a capacidade de coagulação do sangue.',
            ],
            [
                'name' => 'Anti-hipertensivos',
                'description' => 'Medicamentos utilizados para o controle da pressão arterial.',
            ],
            [
                'name' => 'Antidepressivos',
                'description' => 'Medicamentos utilizados principalmente no tratamento da depressão.',
            ],
            [
                'name' => 'Test class',
                'description' => null
            ]
        ];

        DB::table('classifications')->insert($data);
    }
}
