<?php
    class makeGraph {
        public $graph;

        public function showGraph() {
            return $this->graph;
        }

        public function contains($node) {
            return $this->graph[$node];
        }

        public function addNode($node) {
            if(!$this->contains($node)) {
                $this->graph[$node] = array("edges"=>array());
            }
        }

        public function removeNode($node) {
            //Iterate through each nodes' edges and remove relationships
            foreach ($this->graph[$node] as $nodes) {
                foreach ($nodes as $node_id => $edges) {
                    if($this->graph[$node_id]['edges'][$node]) {
                        unset($this->graph[$node_id]['edges'][$node]);
                    }
                }
            }
            unset($this->graph[$node]);
        }

        public function searchNode($node) {
            if($this->contains($node)) {
                return $this->graph[$node];
            }
        }

        public function addEdge($startNode,$endNode) {
            if($this->contains($startNode) && $this->contains($endNode)) {
                $this->graph[$startNode]['edges'][$endNode] = true;
                $this->graph[$endNode]['edges'][$startNode] = true;
            }
        }

        public function removeEdge($startNode,$endNode) {
            if($this->contains($startNode) && $this->contains($endNode)) {
                unset($this->graph[$startNode]['edges'][$endNode]);
                unset($this->graph[$endNode]['edges'][$startNode]);
            }
        }

        public function searchEdge($startNode,$endNode) {
            if($this->graph[$startNode]['edges'][$endNode] && $this->graph[$endNode]['edges'][$startNode]) {
                return array($this->graph[$startNode],$this->graph[$endNode]);
            }
        }
    }

    $simpleGraph = new makeGraph();
    $simpleGraph->addNode('A');
    $simpleGraph->addNode('B');
    $simpleGraph->addNode('C');
    $simpleGraph->addNode('D');
    echo json_encode($simpleGraph->showGraph()).' // 4 nodes added<br />';
    $simpleGraph->addEdge('A','B');
    $simpleGraph->addEdge('A','C');
    echo json_encode($simpleGraph->showGraph()).' // Edge A-B & A-C added<br />';
    $simpleGraph->removeEdge('A','B');
    echo json_encode($simpleGraph->showGraph()).' // Edge A-B removed<br />';
    $simpleGraph->addEdge('A','D');
    echo json_encode($simpleGraph->showGraph()).' // Edge A-D added<br />';
    $simpleGraph->removeNode('D');
    echo json_encode($simpleGraph->showGraph()).' // Node D removed<br />';
    echo json_encode($simpleGraph->searchNode('A')).' // Finds node A and returns its edges<br />';
    echo json_encode($simpleGraph->searchEdge('A','C')).' // Finds edge A-C and returns it<br />';
?>
