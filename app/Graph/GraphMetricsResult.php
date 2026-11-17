<?php

namespace App\Graph;

readonly class GraphMetricsResult {

    /** @param array{degree: int|null, nodeIds: int[]} $maximumDegree */
    public function __construct(
        
        public int $nodeCount,
        public int $edgeCount,

        public float $averageDegree,
        public float $density,

        public int $connectedComponents,
        public array $maximumDegree,
        public ?float $averageEdgeSeverity,
        public int $severeInteractions

    ) {}

}
