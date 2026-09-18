<?php

namespace App\Graph;

use App\Enums\Severity;
use App\Exceptions\Graph\NodeNotFoundException;

class Edge {

    public private(set) int $id;

    public private(set) Node $nodeA;
    public private(set) Node $nodeB;

    public private(set) Severity $severity;

    /** @var array<string, mixed> */
    public private(set) ?array $properties;

    /** @param array<string, mixed> $properties */
    public function __construct(int $id, Node $nodeA, Node $nodeB, Severity $severity, ?array $properties = null) {

        $this->id = $id;
        $this->nodeA = $nodeA;
        $this->nodeB = $nodeB;
        $this->severity = $severity;

        if($properties !== null) {
            $this->properties = $properties;
        }

    }

    public function neighbor(int $nodeId) : Node {

        if($nodeId === $this->nodeA->id) {
            return $this->nodeB;
        }   

        if($nodeId === $this->nodeB->id) {
            return $this->nodeA;
        }

        throw new NodeNotFoundException('No Node with the ID: ' .$nodeId .'find in the Edge' .$this->id);

    }

}
