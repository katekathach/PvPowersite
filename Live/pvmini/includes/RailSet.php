<?php

namespace Schletter\GroundMount;

/**
 * A configuration for one rail row.
 */
class RailSet 
{
    protected $centerRailLength;
    protected $intermediateRailCount;
    protected $intermediateRailLength;
    protected $endRailCount;
    protected $endRailLength;
    // Compare Calculations sheet, checks #1-9. There are a few different tests to determine if the rail set can be used.
    protected $checkPassed; 
    
    public function __construct(
        $centerRailLength = 0, 
        $intermediateRailCount = 0, 
        $intermediateRailLength = 0, 
        $endRailCount = 0, 
        $endRailLength = 0,
        $checkPassed = false
    )
    {
        $this->centerRailLength = $centerRailLength;
        $this->intermediateRailCount = $intermediateRailCount;
        $this->intermediateRailLength = $intermediateRailLength;
        $this->endRailCount = $endRailCount;
        $this->endRailLength = $endRailLength;
        $this->checkPassed = $checkPassed;
    }
    
    /**
     * We round floating point numbers to 2 decimal places to avoid imprecision. 
     */
    public function __get($property)
    {
        if (is_float($this->$property)) {
            return round($this->$property, 2);
        } else {
            return $this->$property;
        }
    }
    
    public function __set($property, $value)
    {
        $this->$property = $value;
    }
}
