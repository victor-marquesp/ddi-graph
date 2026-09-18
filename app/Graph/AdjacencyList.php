<?php

namespace App\Graph;

use App\Graph\Edge;
use App\Graph\Node;
use Override;

class AdjacencyList implements GraphRepresentation {

    /** @var array<int, int[]> */
    public private(set) array $adjacency = [];

    #[Override]
    public function addNode(Node $node) : void {
        
        $this->adjacency[$node->id] = [];

    }

    #[Override]
    public function addEdge(Edge $edge) : void {

        $this->adjacency[$edge->nodeA->id][] = $edge->id;
        $this->adjacency[$edge->nodeB->id][] = $edge->id;

    }

    #[Override]
    /** @return int[] */
    public function incidentEdges(int $nodeId) : array {
        
        return $this->adjacency[$nodeId];

    }

    #[Override]
    public function hasEdge(int $nodeAId, int $nodeBId) : int | bool {
        
        $nodeAEdges = $this->adjacency[$nodeAId];
        $nodeBEdges = $this->adjacency[$nodeBId]; 

        foreach($nodeAEdges as $edge) {

            if(in_array($edge, $nodeBEdges)) {
                return $edge;
            }

        }

        return false;

    }

    #[Override]
    public function degree(int $nodeId) : int {

        return count($this->adjacency[$nodeId]);

    }

}
