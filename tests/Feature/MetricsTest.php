<?php

use App\Models\Interaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('all metrics route works', function () {

    $interactions = Interaction::factory(10)->create();

    $response = $this->get(route('metrics.all'));

    $response->assertOk();
});

test('selected metrics route works', function () {

    $interactions = Interaction::factory(10)->create();

    $drugIds = [];
    foreach ($interactions as $interaction) {
        $drugIds[] = $interaction->drugA_id;
        $drugIds[] = $interaction->drugB_id;
    }

    $response = $this->get(
        route('metrics.selected') .'?' .http_build_query(['drug_ids' => $drugIds])
    );

    $response->assertOk();
});
