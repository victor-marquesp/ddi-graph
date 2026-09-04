<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up() : void {

        Schema::create('interactions', function (Blueprint $table) {
            
            $table->foreignId('drugA_id')->constrained('drugs')->cascadeOnDelete();
            $table->foreignId('drugB_id')->constrained('drugs')->cascadeOnDelete();

            $table->string('severity');
            $table->text('description')->nullable();

            $table->primary(['drugA_id', 'drugB_id']);

            $table->timestamps();
        });

        DB::statement('
            ALTER TABLE interactions
            ADD CONSTRAINT check_drug_order
            CHECK ("drugA_id" < "drugB_id")
        ');
    }

    public function down() : void {

        DB::statement('
            ALTER TABLE interactions
            DROP CONSTRAINT IF EXISTS check_drug_order
        ');

        Schema::dropIfExists('interactions');

    }
};
