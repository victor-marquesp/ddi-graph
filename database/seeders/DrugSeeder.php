<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrugSeeder extends Seeder {

    public function run() : void {

        $data = [
            [
                'name' => 'Paracetamol',
                'description' => 'Analgésico e antitérmico utilizado para o alívio de dores e febre.',
                'classification_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ibuprofeno',
                'description' => 'Anti-inflamatório não esteroidal utilizado para dor, febre e inflamação.',
                'classification_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Aspirina',
                'description' => 'Ácido acetilsalicílico utilizado como analgésico, anti-inflamatório e antiagregante plaquetário.',
                'classification_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Amoxicilina',
                'description' => 'Antibiótico da classe das penicilinas utilizado contra diversas infecções bacterianas.',
                'classification_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Azitromicina',
                'description' => 'Antibiótico macrolídeo utilizado no tratamento de determinadas infecções bacterianas.',
                'classification_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Varfarina',
                'description' => 'Anticoagulante utilizado para prevenir a formação de coágulos sanguíneos.',
                'classification_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Losartana',
                'description' => 'Medicamento utilizado principalmente no tratamento da hipertensão arterial.',
                'classification_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Enalapril',
                'description' => 'Inibidor da ECA utilizado principalmente no tratamento da hipertensão arterial.',
                'classification_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sertralina',
                'description' => 'Antidepressivo da classe dos inibidores seletivos da recaptação de serotonina.',
                'classification_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Fluoxetina',
                'description' => 'Antidepressivo da classe dos inibidores seletivos da recaptação de serotonina.',
                'classification_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
             [
                'name' => 'Test',
                'description' => 'test description',
                'classification_id' => 7,
                'created_at' => now(),
                'updated_at' => now()                
            ]
        ];

        DB::table('drugs')->insert($data);
    }
}
