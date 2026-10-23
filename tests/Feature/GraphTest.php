<?php

use App\Models\Interaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('genereate general graph route works', function () {

    $interactions = Interaction::factory(10)->create();

    $response = $this->get(route('graph.all'));

    $response->assertOk();

});

test('generate specific graph route works', function () {

    $interactions = Interaction::factory(10)->create();

    $drugIds = [];
    foreach ($interactions as $interaction) {
        $drugIds[] = $interaction->drugA_id;
        $drugIds[] = $interaction->drugB_id;
    }

    $response = $this->get(
        route('graph.selected') .'?' .http_build_query(['drug_ids' => $drugIds])
    );

    $response->assertOk();

});
