<?php

namespace Schletter\GroundMount;

/**
 * Check #10.
 * 
 * This one's a bit different from the other checks (RailCheck). It appears to be for the "Simple configuration".
 */

class FinalRailCheck
{
    protected $systemLength;
    protected $stockRail;
    protected $potentialRailCalculator;
    protected $railSet;
    
    public function __construct(
        $systemLength,
        $stockRail,
        PotentialRailCalculator $potentialRailCalculator
    )
    {
        $this->systemLength = $systemLength;
        $this->stockRail = $stockRail;
        $this->potentialRailCalculator = $potentialRailCalculator;
        $this->railSet = new RailSet();
    }
    
    public function run()
    {
        $trials = array(
            'idealRail' => array(),
            'rackRemainderFromCenter' => array(),
            'checkPassed' => array(),
        );
        for ($i = 1; $i <= 4; $i++) {
            $idealRail = $this->potentialRailCalculator->getIdealRail($this->stockRail, $this->systemLength, $i - 1);
            $rackRemainderFromCenter = $this->systemLength - $idealRail;
            $checkPassed = in_array(round($rackRemainderFromCenter, 2), $this->potentialRailCalculator->getRails()) &&
                ($this->systemLength <= ($this->stockRail * 2)) && ($rackRemainderFromCenter <= $this->stockRail);
            if ($checkPassed) {
                $trials['idealRail'][$i] = $idealRail;
                $trials['rackRemainderFromCenter'][$i] = $rackRemainderFromCenter;
                $trials['checkPassed'][$i] = $checkPassed;
            }
        }
        
        $this->railSet->centerRailLength = 0;
        $this->railSet->intermediateRailLength = 0;
        $this->railSet->intermediateRailCount = 0;
        $this->railSet->endRailLength = 0;
        $this->railSet->endRailCount = 0;
        $this->railSet->checkPassed = false;
        if (!empty($trials['rackRemainderFromCenter'])) {
            $trialNumbers = array_keys($trials['rackRemainderFromCenter']);
            $firstTrial = $trialNumbers[0];            
            $this->railSet->centerRailLength = $trials['rackRemainderFromCenter'][$firstTrial];
            $this->railSet->intermediateRailLength = $trials['idealRail'][$firstTrial];
            if ($this->railSet->intermediateRailLength) {
                $this->railSet->intermediateRailCount = 1;
            }
            if ($this->railSet->intermediateRailLength <= $this->stockRail) {
                $this->railSet->checkPassed = true;   
            }
        }
        
        return $this->railSet;
    }
}
