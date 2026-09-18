<?php

namespace App\Graph;

use App\Exceptions\Graph\EdgeNotFoundException;
use App\Exceptions\Graph\InvalidEdgeException;
use App\Exceptions\Graph\InvalidNodeException;
use App\Exceptions\Graph\NodeNotFoundException;
use App\Graph\Edge;
use App\Graph\Node;

class Graph {

    /** @var array<int, Node> */
    public private(set) array $nodes = [];

    /** @var array<int, Edge> */
    public private(set) array $edges = [];

    public private(set) GraphRepresentation $representation;

    public function __construct(GraphRepresentation $representation) {
        $this->representation = $representation;    
    }

    public function addNode(Node $node) : void {

        if(isset($this->nodes[$node->id])) {
            throw new InvalidNodeException('Node ID already exists');
        }

        $this->nodes[$node->id] = $node;
        $this->representation->addNode($node);
    }

    public function addEdge(Edge $edge) : void {

        if(isset($this->edges[$edge->id])) {
            throw new InvalidEdgeException('Edge ID already exists');
        }

        if(!isset($this->nodes[$edge->nodeA->id])) {
            throw new InvalidEdgeException('Node A does not belong to the graph');
        }

        if(!isset($this->nodes[$edge->nodeB->id])) {
            throw new InvalidEdgeException('Node B does not belong to the graph');
        }

        if($this->representation->hasEdge($edge->nodeA->id, $edge->nodeB->id)) {
            throw new InvalidEdgeException('Edge already exists');
        }

        if($edge->nodeA->id === $edge->nodeB->id) {
            throw new InvalidEdgeException('Self-loops are not allowed');
        }

        $this->edges[$edge->id] = $edge;
        $this->representation->addEdge($edge);
    }

    public function getNode(int $id) : Node {

        return $this->nodes[$id] ?? throw new NodeNotFoundException('No Node found with the ID: ' .$id);

    }

    public function getEdge(int $id) : Edge {

        return $this->edges[$id] ?? throw new EdgeNotFoundException('No Edge found with the ID: ' .$id);

    }

    public function nodeCount() : int {

        return count($this->nodes);

    }

    public function edgeCount() : int {

        return count($this->edges);

    }

    public function hasEdge(int $nodeAId, int $nodeBId) : ?Edge {

        if(!isset($this->nodes[$nodeAId])) {
            throw new NodeNotFoundException('No Node found with the ID: ' .$nodeAId);
        }

        if(!isset($this->nodes[$nodeBId])) {
            throw new NodeNotFoundException('No Node found with the ID: ' .$nodeBId);
        }

        $edgeId = $this->representation->hasEdge($nodeAId, $nodeBId);

        if($edgeId) {
            return $this->edges[$edgeId];
        }

        return null;
    }

    /** @return Edge[] */
    public function incidentEdges(int $nodeId) : array {

        if(!isset($this->nodes[$nodeId])) {
            throw new NodeNotFoundException('No Node found with the ID: ' .$nodeId);
        }

        $edgeIdList = $this->representation->incidentEdges($nodeId);

        $edges = [];
        foreach($edgeIdList as $edgeId) {
            $edges[] = $this->edges[$edgeId];
        }

        return $edges; 
    }

    /** @return Node[] */
    public function neighbors(int $nodeId) : array {

        if(!isset($this->nodes[$nodeId])) {
            throw new NodeNotFoundException('No Node found with the ID: ' .$nodeId);
        }

        $edgeIdList = $this->representation->incidentEdges($nodeId);

        $neighbors = [];
        foreach($edgeIdList as $edgeId) {
            
            $edge = $this->edges[$edgeId];

            $neighbors[] = $edge->neighbor($nodeId);

        }

        return $neighbors;

    }

    public function degree(int $nodeId) : int {

        if(!isset($this->nodes[$nodeId])) {
            throw new NodeNotFoundException('No Node found with the ID: ' .$nodeId);
        }

        return $this->representation->degree($nodeId);
    }

}
