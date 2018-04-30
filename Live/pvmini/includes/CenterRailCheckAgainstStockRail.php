<?php

namespace Schletter\GroundMount;

use Schletter\GroundMount\OppositeRailCheck;
use Schletter\GroundMount\RailSet;

class CenterRailCheckAgainstStockRail extends OppositeRailCheck 
{
    protected $potentialCenterRailCalculator;
    
    /**
     * It looks like there's a bug in Calculations!H30: =IF(H29=$H$4:$V$4,$H$4:$V$4,0)
     * This appears to compare H29 ($centerRailLength) to H4 through V4 ($this->potentialCenterRailCalculator->getRails()).
     * But really it just compares to H4. We'll reproduce this bug here.
     */
    public function check($idealRemainingRailLengths, $remainingRails, RailSet $railSet, $rackRemainderFromCenter)
    {
        $centerRailLength = ($rackRemainderFromCenter - $idealRemainingRailLengths * floor($remainingRails)) * 2;
        $idealCenterRail = 0;

        // I think Calculations!H30 should translate to this:
        // if (null !== $this->potentialCenterRailCalculator && in_array(round($centerRailLength, 1), $this->potentialCenterRailCalculator->getRails())) {
        $tmpRails = $this->potentialCenterRailCalculator->getRails();
        if (null !== $this->potentialCenterRailCalculator && round($centerRailLength, 1) == $tmpRails[1]) {
           $idealCenterRail = $centerRailLength;
        }

        if (0 === $idealCenterRail) {
            $checkPassed = false;
        } elseif (($centerRailLength > $this->stockRail) || (0 === $this->idealRail)) {
            $checkPassed = false;    
        } else {
            $checkPassed = true;
        }
                
        $railSet->centerRailLength = $centerRailLength;
        $railSet->checkPassed = $checkPassed;

        return $railSet;
    }
    
    public function setCenterRailCalculator(PotentialRailCalculator $potentialCenterRailCalculator)
    {
        $this->potentialCenterRailCalculator = $potentialCenterRailCalculator;
    }
}
