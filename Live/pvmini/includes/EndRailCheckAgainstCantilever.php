<?php

namespace Schletter\GroundMount;

use Schletter\GroundMount\OppositeRailCheck;
use Schletter\GroundMount\RailSet;

class EndRailCheckAgainstCantilever extends OppositeRailCheck 
{
    public function check($idealRemainingRailLengths, $remainingRails, RailSet $railSet, $rackRemainderFromCenter = 0)
    {
        $endRailLength = round(($remainingRails - floor($remainingRails)) * $idealRemainingRailLengths, 2);
        
        $cantileverPlus75Percent = $this->cantilever + (1 - $this->splicePercentage) * $this->span;
        if (0 === $this->idealRail) {
            $checkPassed = false;
        } elseif ($this->systemLength <= $this->stockRail) {
            $checkPassed = true;    
        } elseif ($endRailLength < $cantileverPlus75Percent) {
            $checkPassed = false;
        } else {
            $checkPassed = true;
        }
        
        $endRailCount = (int) ceil($remainingRails - floor($remainingRails)) * 2;
        
        $railSet->endRailLength = $endRailLength;
        $railSet->endRailCount = $endRailCount;
        $railSet->checkPassed = $checkPassed;
        
        return $railSet;
    }
}
