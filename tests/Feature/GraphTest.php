<?php

test('genereate general graph route works', function () {

    $response = $this->get(route('graph.all'));

    $this->assertOk($response);

});
