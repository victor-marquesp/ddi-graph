<?php

namespace App\Graph;

use App\Models\Drug;
use App\Models\Interaction;

class GraphBuilder {

    /** @param Drug[] $drugs @param Interaction[] $interactions */
    public function build(array $drugs, array $interactions) : Graph {

        $representation = new AdjacencyList();

        $graph = new Graph($representation);

        foreach($drugs as $drug) {

            $node = new Node(
                id: $drug->id,
                classification: $drug->classification,
                labels: ['drug'],
                properties: $drug->toNodeProperties()
            );

            $graph->addNode($node);

        }

        $id = 1;
        foreach($interactions as $interaction) {
            
            $edge = new Edge(
                id: $id,
                nodeA: $graph->getNode($interaction->drugA_id),
                nodeB: $graph->getNode($interaction->drugB_id),
                severity: $interaction->severity,
                properties: $interaction->toEdgeProperties() 
            );

            $graph->addEdge($edge);

            $id++;
        }

        return $graph;

    }

}