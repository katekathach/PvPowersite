<?php 

namespace Schletter\GroundMount;

use Schletter\GroundMount\PotentialRailCalculator;

class PotentialIntermediateRailCalculator extends PotentialRailCalculator
{
    protected function calculate($span, $supportCount, $splicePercentage, $cantilever)
    {
        if ($supportCount % 2 == 0) {
            $this->potentialRails[1] = $span / 2;
        } else {
            $this->potentialRails[1] = $span;
        }
        for ($i = 2; $i <= 15; $i++) {
            $this->potentialRails[$i] = $this->potentialRails[1] * $i;
        }
            
        return $this->potentialRails;
    }
}
