<?php

namespace Schletter\GroundMount;

use Schletter\GroundMount\OppositeRailCheck;
use Schletter\GroundMount\RailSet;
use Schletter\GroundMount\PotentialIntermediateRailCalculator;

/**
 * Calculations sheet, checks #1-#9
 */
class RailCheck
{
    protected $idealRail;
    protected $systemLength;
    protected $oppositeRailCheck;
    protected $idealRemainingRailLength;
    protected $centerOrEnd;
    protected $railSet;
    
    public function __construct(
        $idealRail,
        $systemLength,
        OppositeRailCheck $oppositeRailCheck,
        $idealRemainingRailLength,
        $centerOrEnd = 'center'
    )
    {
        $this->idealRail = $idealRail;
        $this->systemLength = $systemLength;
        $this->oppositeRailCheck = $oppositeRailCheck;
        $this->idealRemainingRailLength = $idealRemainingRailLength;
        $this->centerOrEnd = $centerOrEnd;
        $this->railSet = new RailSet();
    }
    
    /**
     * Run the rail check.
     * 
     * @return RailSet railSet
     */
    public function run() 
    {
        if ('center' === $this->centerOrEnd) {
            $rackRemainderFromCenter = ($this->systemLength - $this->idealRail) / 2;    
        } else {
            $rackRemainderFromCenter = ($this->systemLength - $this->idealRail * 2) / 2;
        }
                
        $remainingRails = $this->idealRemainingRailLength == 0 ? 0 : $rackRemainderFromCenter / $this->idealRemainingRailLength; 

        $railSet = $this->oppositeRailCheck->check($this->idealRemainingRailLength, $remainingRails, $this->railSet, $rackRemainderFromCenter);

        $intermediateRailCount = (int) floor($remainingRails) * 2;

        if ('center' === $this->centerOrEnd) { 
            $this->railSet->centerRailLength = $this->idealRail;
        } else {
            $this->railSet->endRailLength = $this->idealRail;
            $this->railSet->endRailCount = (int) ceil($remainingRails - floor($remainingRails)) * 2;
        }
        
        $this->railSet->intermediateRailCount = $intermediateRailCount;
        $this->railSet->intermediateRailLength = $this->idealRemainingRailLength;
        
        return $this->railSet;
    }
    
}
