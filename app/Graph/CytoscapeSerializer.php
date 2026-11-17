<?php

namespace App\Graph;

class CytoscapeSerializer {

    public function serialize(Graph $graph) : array {

        $nodes = [];
        $edges = [];

        foreach ($graph->nodes as $node) {
            $nodes[] = $this->serializeNode($node, $graph);
        }

        foreach ($graph->edges as $edge) {
            $edges[] = $this->serializeEdge($edge);
        }

        return [
            'nodes' => $nodes,
            'edges' => $edges
        ];

    }

    private function serializeNode(Node $node, Graph $graph) : array {

        return [
            'data' => [
                'id' => 'n' . $node->id,
                'drugId' => $node->id,
                'name' => $node->properties['name'],
                'description' => $node->properties['description'] ?? null,
                'classification' => $node->classification->name,
                'classificationId' => $node->classification->id,
                'degree' => $graph->degree($node->id),
                'url' => route('drugs.show', $node->id)
            ]
        ];

    }

    private function serializeEdge(Edge $edge) : array {

        return [
            'data' => [
                'id' => 'e' . $edge->id,
                'source' => 'n' . $edge->nodeA->id,
                'target' => 'n' . $edge->nodeB->id,
                'severity' => $edge->severity->value,
                'description' => $edge->properties['description'] ?? null,
                'url' => route('interactions.show', [
                    'drugA' => $edge->nodeA->id,
                    'drugB' => $edge->nodeB->id
                ])
            ]
        ];

    }

}
