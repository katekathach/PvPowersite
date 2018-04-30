<?php 

namespace Schletter\GroundMount;

abstract class OptimalRailCut
{
    protected $stockRailCut;
    
    public function __construct($stockRailCut = null)
    {
        $this->stockRailCut = $stockRailCut;
    }
    
    public function getMostEfficientRails() 
    {
        $railCombinationMatrix = $this->getRailCombinationMatrix();

        $optimalLength = array();
        foreach ($railCombinationMatrix as $key => $combination) {
            $totalLength = 0;
            foreach ($combination as $subKey => $count) {
                list($position, $length) = explode('-', $subKey);
                $totalLength += $length * $count; 
            }
            $optimalLength[$key] = $totalLength;
        }
        // Get the combination that has a total length closest to but less than the stockRail
        $optimalKey = null;
        $stockRails = $this->stockRailCut->getStockRails();
        $previousLength = 0;
        foreach ($optimalLength as $key => $length) {
            if ($length <= $stockRails[$this->stockRail] && $length > $previousLength) {
                $optimalKey = $key;
                $previousLength = $length;
            }
        }
        
        $requiredRails = $this->stockRailCut->getRequiredRails();
        $optimalCombination = array(
            'center-'.$requiredRails['center'] => 0,
            'intermediate-'.$requiredRails['intermediate'] => 0,
            'end-'.$requiredRails['end'] => 0,
        );
        $requiredQuantities = $this->stockRailCut->getRequiredQuantities();
        
        if (null !== $optimalKey) {
            $optimalCombination = $railCombinationMatrix[$optimalKey];
            /*foreach ($optimalCombination as $key => $count) {
                if (!$count) {
                    list($position, $length) = explode('-', $key);
                    unset($requiredQuantities[$position]);
                }
            } */
        }

        $used = array(
            'center' => 0,
            'intermediate' => 0,
            'end' => 0,
        );
        $usedTemp = array();
        foreach ($requiredQuantities as $position => $count) {
            if (0 !== $optimalCombination[$position.'-'.$requiredRails[$position]]) {
                $usedTemp[$position] = $requiredQuantities[$position] / $optimalCombination[$position.'-'.$requiredRails[$position]];
            }
        }
        
        if (!empty($usedTemp)) {
            foreach ($used as $position => $quantity) {
                $used[$position] = min($usedTemp);
            }
        }
        $usedMax = max($used);
        
        $remainingRails = array();
        $realRequiredQuantities = $this->stockRailCut->getRequiredQuantities();
        foreach ($realRequiredQuantities as $position => $count) {
            $remainingRails[$position] = $realRequiredQuantities[$position] - $used[$position] * $optimalCombination[$position.'-'.$requiredRails[$position]];
        }
                        
        $mostEfficientStockRails = $this->stockRailCut->getMostEfficientRails();
        $fromStock = $mostEfficientStockRails['fromStock'];
        
        $fullSections = array();
        foreach ($remainingRails as $position => $count) {
            if (0 === $fromStock[$position]) {
                $fullSections[$position] = 0;
            } else {
                $fullSections[$position] = ceil($count / (float) $fromStock[$position]);
            }
        }
        
        $fullSectionsTotal = array_sum($fullSections);

        $railsShipping = (int) $usedMax + (int) $fullSectionsTotal;
        
        $totalShippingLength = $usedMax * $stockRails[$this->stockRail] +
            $fullSections['center'] * $mostEfficientStockRails['choose']['center'] +
            $fullSections['intermediate'] * $mostEfficientStockRails['choose']['intermediate'] +
            $fullSections['end'] * $mostEfficientStockRails['choose']['end']
        ;
        
        $totalShippingLength = (int) $totalShippingLength;
        $wasteLength = $totalShippingLength - $mostEfficientStockRails['totalRequiredLength'];
        $wastePercentage = round($wasteLength / $totalShippingLength, 2);

        // Instructions
        $instructions = array(
            1 => '',
            2 => '',
            3 => '',
            4 => '',                                    
        );
        $stockRailQuantity = array();
        foreach ($stockRails as $rail) {
            // Duplicate keys OK here.
            $stockRailQuantity[$rail] = 0;
        }
        if (0 === $usedMax) {
            ;
        } else {
            $centerLength = $requiredRails['center'];
            $centerCount = $optimalCombination['center-'.$centerLength] * $usedMax;
            if (0 !== $centerCount) {
                $instructions[1] = "Cut ($centerCount) {$centerLength}mm rail(s)";
            }
            $intermediateLength = $requiredRails['intermediate'];
            $intermediateCount = $optimalCombination['intermediate-'.$intermediateLength] * $usedMax;
            if (0 !== $intermediateCount) {
                $instructions[1] .= " &amp; ($intermediateCount) {$intermediateLength}mm rail(s)";
            }
            $endLength = $requiredRails['end'];
            $endCount = $optimalCombination['end-'.$endLength] * $usedMax;
            if (0 !== $endCount) {
                $instructions[1] .= " &amp; ($endCount) {$endLength}mm rail(s)";
            }
            $instructions[1] .= " from ($usedMax) {$stockRails[$this->stockRail]}mm stock rails.";
            $stockRailQuantity[$stockRails[$this->stockRail]] += $usedMax;
        }
        
        $i = 2;
        foreach ($requiredRails as $position => $length) {
            if (0 == $fullSections[$position]) {
                ;
            } else {
                $cut = $fullSections[$position] * $fromStock[$position];
                $instructions[$i] .= "Cut ($cut) {$length}mm rail(s) from ({$fullSections[$position]}) {$mostEfficientStockRails['choose'][$position]}mm stock rails.";
            }
            $i++;
            $stockRailQuantity[$mostEfficientStockRails['choose'][$position]] += $fullSections[$position];
        }
        
        return compact('railsShipping', 'totalShippingLength', 'wasteLength', 'wastePercentage', 'instructions', 'stockRailQuantity');
    }
    
    abstract protected function getRailCombinationMatrix();
}
