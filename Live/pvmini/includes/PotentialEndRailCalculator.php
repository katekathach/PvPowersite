<?php 

namespace Schletter\GroundMount;

use Schletter\GroundMount\PotentialRailCalculator;

class PotentialEndRailCalculator extends PotentialRailCalculator
{
    protected function calculate($span, $supportCount, $splicePercentage, $cantilever)
    {
        $this->potentialRails[0] = round($cantilever + (1 - $splicePercentage) * $span, 2);
        
        for ($i = 1; $i <= 14; $i++) {
            if ($i % 2 == 0) {
                $this->potentialRails[$i] = round($this->potentialRails[$i - 1] + $span * (1 - $splicePercentage * 2), 2);
            } else {
                $this->potentialRails[$i] = round($this->potentialRails[$i - 1] + $span * $splicePercentage * 2, 2);
            }
        }
            
        return $this->potentialRails;
    }
}
