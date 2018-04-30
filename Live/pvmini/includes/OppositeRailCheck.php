<?php

namespace Schletter\GroundMount;

use Schletter\GroundMount\RailSet;

abstract class OppositeRailCheck 
{
    protected $cantilever;
    protected $splicePercentage;
    protected $span;
    protected $stockRail;
    protected $idealRail;
    protected $systemLength;
    
    /**
     * Inherent in the subclasses.
     */
    protected $centerOrEnd;
    
    public function __construct($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength)
    {
        $this->cantilever = $cantilever;
        $this->splicePercentage = $splicePercentage;
        $this->span = $span;
        $this->stockRail = $stockRail;
        $this->idealRail = $idealRail;
        $this->systemLength = $systemLength;
    }
    
    abstract function check($idealRemainingRailLengths, $remainingRails, RailSet $railSet, $rackRemainderFromCenter);
}
