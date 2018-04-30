<?php 

namespace Schletter\GroundMount;

use Schletter\GroundMount\PotentialRailCalculator;

class PotentialCenterRailCalculator extends PotentialRailCalculator
{
    protected function calculate($span, $supportCount, $splicePercentage, $cantilever)
    {
        if ($supportCount % 2 == 0) {
            $this->potentialRails[1] = $span * (1 - $splicePercentage * 2);
            $this->potentialRails[2] = $span * ($splicePercentage * 2) * 2 + $this->potentialRails[1];
            for ($i = 3; $i <= 15; $i++) {
                $this->potentialRails[$i] = round($span * 2 + $this->potentialRails[$i - 2], 1);
            }
        } else {
            $this->potentialRails[1] = $span * $splicePercentage * 2;
            $this->potentialRails[2] = $span * (1 - $splicePercentage * 2) * 2 + $this->potentialRails[1];
            for ($i = 3; $i <= 15; $i++) {
                $percentage = $splicePercentage * 2;
                if ($i % 2 == 0) {
                    $percentage = (1 - $splicePercentage * 2);
                }
                $this->potentialRails[$i] = $span * $percentage * 2 + $this->potentialRails[$i - 1];
            }
        }
        
        return $this->potentialRails;
    }
}
