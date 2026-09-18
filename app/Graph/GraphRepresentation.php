<?php

namespace App\Graph;

use App\Graph\Edge;
use App\Graph\Node;

interface GraphRepresentation {

    public function addNode(Node $node) : void;

    public function addEdge(Edge $edge) : void;

    /** @return int[] */
    public function incidentEdges(int $nodeId) : array;

    public function hasEdge(int $nodeAId, int $nodeBId) : int | bool;

    public function degree(int $nodeId) : int;

}
