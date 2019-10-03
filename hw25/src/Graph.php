<?php
declare(strict_types=1);

/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

class Graph
{
    private const EDGE_START_INDEX = 0;
    private const EDGE_END_INDEX = 1;
    private const EDGE_WEIGHT_INDEX = 2;

    private $weightMatrix;
    private $numberOfVertices;

    public function loadGraphFromJSON(string $pathToFile): void
    {
        $graphData = (array)json_decode(file_get_contents($pathToFile), false);
        $this->calculateNumberOfVertices($graphData);
        $this->setEmptyMatrix();
        $this->fillMatrixWeights($graphData);
    }

    public function getWeightMatrix(): array
    {
        return $this->weightMatrix ?? [];
    }

    public function getNumberOfVertices(): int
    {
        return $this->numberOfVertices ?? 0;
    }

    private function calculateNumberOfVertices(array $vertices): void
    {
        $verticesNumbers = array_merge(
            array_column($vertices, self::EDGE_START_INDEX),
            array_column($vertices, self::EDGE_END_INDEX)
        );

        $this->numberOfVertices = max($verticesNumbers);
    }

    private function setEmptyMatrix(): void
    {
        $this->weightMatrix = array_fill(
            1, $this->numberOfVertices,
            array_fill(1, $this->numberOfVertices, 0)
        );
    }

    private function fillMatrixWeights(array $graphData): void
    {
        foreach ($graphData as $vertex) {
            $this->weightMatrix[$vertex[self::EDGE_START_INDEX]][$vertex[self::EDGE_END_INDEX]] = $vertex[self::EDGE_WEIGHT_INDEX];
        }
    }
}