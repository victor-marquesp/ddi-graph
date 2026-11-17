<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Models\Classification;
use App\Models\Drug;
use App\Models\Interaction;
use App\Enums\Severity;

use Generator;
use RuntimeException;

class ImportDataset extends Command {

    protected $signature = 'dataset:import';

    protected $description = 'Import processed pharmaceutical datasets';

    private array $classifications = [];
    private array $drugs = [];

    public function handle() : int {

        if (
            Classification::exists() ||
            Drug::exists() ||
            Interaction::exists()
        ) {
            $this->error('The database must be empty.');

            return self::FAILURE;
        }

        DB::transaction(function () {

            $this->importClassifications();
            $this->importDrugs();
            $this->importInteractions();

        });

        $this->info('Dataset imported successfully.');

        return self::SUCCESS;
    }

    private function importClassifications() : void {

        $this->info('Importing classifications...');

        foreach ($this->readCsv('classifications.csv') as $row) {

            $classification = Classification::create([
                'name' => $row['name'],
                'description' => $row['description'] ?: null
            ]);

            $this->classifications[$row['code']] = $classification->id;
        }

        $this->info(
            'Classifications imported: ' . count($this->classifications)
        );
    }

    private function importDrugs() : void {

        $this->info('Importing drugs...');

        foreach ($this->readCsv('drugs.csv') as $row) {

            $drug = Drug::create([
                'name' => $row['name'],
                'description' => $row['description'] ?: null,
                'classification_id' => $this->classifications[
                    $row['classification_code']
                ]
            ]);

            $this->drugs[$row['external_id']] = $drug->id;
        }

        $this->info(
            'Drugs imported: ' . count($this->drugs)
        );
    }

    private function importInteractions() : void {

        $this->info('Importing interactions...');

        $batch = [];
        $count = 0;

        $timestamp = now();
        $usesTimestamps = (new Interaction())->usesTimestamps();

        foreach ($this->readCsv('interactions.csv') as $row) {

            $ids = [
                $this->drugs[$row['drug_a']],
                $this->drugs[$row['drug_b']]
            ];

            sort($ids, SORT_NUMERIC);

            $interaction = [
                'drugA_id' => $ids[0],
                'drugB_id' => $ids[1],
                'severity' => Severity::from(
                    strtolower($row['severity'])
                )->value,
                'description' => $row['description'] ?: null
            ];

            if ($usesTimestamps) {
                $interaction['created_at'] = $timestamp;
                $interaction['updated_at'] = $timestamp;
            }

            $batch[] = $interaction;

            $count++;

            if (count($batch) >= 1000) {

                Interaction::insert($batch);

                $batch = [];
            }
        }

        if (!empty($batch)) {
            Interaction::insert($batch);
        }

        $this->info("Interactions imported: {$count}");
    }

    private function readCsv(string $filename) : Generator {

        $path = database_path(
            "datasets/processed/{$filename}"
        );

        $file = fopen($path, 'r');

        if ($file === false) {
            throw new RuntimeException(
                "Unable to open {$filename}"
            );
        }

        try {

            $header = fgetcsv($file, escape: '');

            if ($header === false) {
                throw new RuntimeException(
                    "Empty CSV file: {$filename}"
                );
            }

            while (($row = fgetcsv($file, escape: '')) !== false) {

                yield array_combine($header, $row);
            }

        } finally {

            fclose($file);
        }
    }
}