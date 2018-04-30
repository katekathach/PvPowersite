<?php 

namespace Schletter\GroundMount;

use Schletter\GroundMount\RailCut;

class StockRailCut extends RailCut
{    
    /**
     * See 'Cutting Stock v2'!B8:X12
     */
    public function getMostEfficientRails()
    {
        $totalRequiredLength = 0;
        foreach ($this->requiredRails as $position => $length) {
            $totalRequiredLength += $length * $this->requiredQuantities[$position];
        }
        
        $railsShipping = 0;
        $totalShippingLength = 0;
        
        $stockRailMatrix = array();
        foreach ($this->requiredRails as $position => $length) {
            $stockRailMatrix[$position] = array();
            foreach ($this->stockRails as $railNumber => $stockRail) {
                if (0 === $length) {
                    $quantity = 0;
                } else {
                    $quantity = floor($stockRail / $length);
                }
                $stockRailMatrix[$position][$railNumber] = array(
                    'quantity' => $quantity,
                    'percentage' => round(($quantity * $length) / $stockRail, 2),
                    'stockRail' => $stockRail,
                );
            }
            $temp = $stockRailMatrix[$position];
            uasort($temp, function($a, $b) {
                if ($a['percentage'] == $b['percentage']) {
                    return 0;
                } elseif ($a['percentage'] < $b['percentage']) {
                    return -1;
                } else {
                    return 1;
                }
            });
            $bestChoice = array_pop($temp);
            $stockRailMatrix[$position]['choose'] = $bestChoice['stockRail'];
            $stockRailMatrix[$position]['fromStock'] = $bestChoice['quantity'];
            if (0 === $bestChoice['quantity']) {
                $stockRailMatrix[$position]['fromStockPercentage'] = 0;
            } else {
                $stockRailMatrix[$position]['fromStockPercentage'] = 1 / $bestChoice['quantity'];
            }
            $stockRailMatrix[$position]['finalQuantity'] = ceil($stockRailMatrix[$position]['fromStockPercentage'] * $this->requiredQuantities[$position]);
            $railsShipping += $stockRailMatrix[$position]['finalQuantity'];
            $totalShippingLength += $bestChoice['stockRail'] * $stockRailMatrix[$position]['finalQuantity'];
        }
                
        $wasteLength = $totalShippingLength - $totalRequiredLength;
        
        $fromStock = array();
        $choose = array();
        foreach ($stockRailMatrix as $position => $value) {
            $fromStock[$position] = $value['fromStock'];
            $choose[$position] = $value['choose'];
        }
        
        $stockRailQuantity = array();
        foreach ($this->stockRails as $rail) {
            // Duplicate keys OK here.
            $stockRailQuantity[$rail] = 0;
        }
        
        $instructions = array(1 => '');
        $line = 2;
        foreach ($this->requiredRails as $position => $length) {
            $cuts = $stockRailMatrix[$position]['fromStock'] * $stockRailMatrix[$position]['finalQuantity'];
            if (0 == $cuts) {
                $instructions[$line] = '';
            } else {
                $instructions[$line] = "Cut ({$cuts}) {$length}mm rail(s) from".
                    " ({$stockRailMatrix[$position]['finalQuantity']})".
                    " {$stockRailMatrix[$position]['choose']}mm stock rails.";
            }
            $line++;
            $stockRailQuantity[$stockRailMatrix[$position]['choose']] += $stockRailMatrix[$position]['finalQuantity'];
        }
        
        return array(
            'railsShipping' => (int) $railsShipping,
            'totalShippingLength' => (int) $totalShippingLength,
            'wasteLength' => (int) $wasteLength,
            'wastePercentage' => round($wasteLength / $totalShippingLength, 4),
            'fromStock' => $fromStock,
            'choose' => $choose,
            'totalRequiredLength' => $totalRequiredLength,
            'instructions' => $instructions, 
            'stockRailQuantity' => $stockRailQuantity,
        );
    }
}
