<?php

namespace Database\Seeders;

use App\Enums\Severity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InteractionSeeder extends Seeder {
    
    public function run() : void {
        
        $data = [
            [
                'drugA_id' => 1,
                'drugB_id' => 2,
                'severity' => Severity::MODERATE,
                'description' => 'O uso concomitante requer atenção devido ao potencial aumento de efeitos adversos.',
            ],
            [
                'drugA_id' => 1,
                'drugB_id' => 6,
                'severity' => Severity::MAJOR,
                'description' => 'O uso concomitante pode exigir monitoramento devido ao possível aumento do risco de sangramento.',
            ],
            [
                'drugA_id' => 2,
                'drugB_id' => 3,
                'severity' => Severity::MAJOR,
                'description' => 'A combinação pode aumentar o risco de efeitos adversos gastrointestinais e hemorrágicos.',
            ],
            [
                'drugA_id' => 2,
                'drugB_id' => 6,
                'severity' => Severity::CONTRAINDICATED,
                'description' => 'O uso concomitante pode aumentar significativamente o risco de sangramento.',
            ],
            [
                'drugA_id' => 2,
                'drugB_id' => 7,
                'severity' => Severity::MODERATE,
                'description' => 'O uso concomitante pode reduzir o efeito anti-hipertensivo e afetar a função renal.',
            ],
            [
                'drugA_id' => 2,
                'drugB_id' => 8,
                'severity' => Severity::MODERATE,
                'description' => 'O uso concomitante pode reduzir o efeito anti-hipertensivo e aumentar o risco de alterações renais.',
            ],
            [
                'drugA_id' => 3,
                'drugB_id' => 6,
                'severity' => Severity::CONTRAINDICATED,
                'description' => 'A combinação pode aumentar significativamente o risco de sangramento.',
            ],
            [
                'drugA_id' => 4,
                'drugB_id' => 6,
                'severity' => Severity::MAJOR,
                'description' => 'Pode ocorrer alteração do efeito anticoagulante, sendo recomendado monitoramento.',
            ],
            [
                'drugA_id' => 5,
                'drugB_id' => 6,
                'severity' => Severity::MAJOR,
                'description' => 'A combinação pode alterar o efeito anticoagulante e requer atenção clínica.',
            ],
            [
                'drugA_id' => 6,
                'drugB_id' => 9,
                'severity' => Severity::MAJOR,
                'description' => 'A combinação pode aumentar o risco de sangramento.',
            ],
            [
                'drugA_id' => 6,
                'drugB_id' => 10,
                'severity' => Severity::MAJOR,
                'description' => 'A combinação pode aumentar o risco de sangramento e requer monitoramento.',
            ],
            [
                'drugA_id' => 7,
                'drugB_id' => 8,
                'severity' => Severity::MAJOR,
                'description' => 'A combinação pode aumentar o risco de hipotensão e alterações da função renal.',
            ],
            [
                'drugA_id' => 9,
                'drugB_id' => 10,
                'severity' => Severity::CONTRAINDICATED,
                'description' => 'A combinação pode aumentar a atividade serotoninérgica e o risco de efeitos adversos graves.',
            ],
        ];

        DB::table('interactions')->insert($data);
    }
}
