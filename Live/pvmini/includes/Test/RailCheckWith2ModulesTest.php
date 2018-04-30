<?php 

namespace Schletter\GroundMount\Test;

use Schletter\GroundMount\RailCheck;
use Schletter\GroundMount\RailSet;
use Schletter\GroundMount\EndRailCheckAgainstCantilever;
use Schletter\GroundMount\CenterRailCheckAgainstStockRail;
use Schletter\GroundMount\PotentialCenterRailCalculator;
use Schletter\GroundMount\PotentialEndRailCalculator;
use Schletter\GroundMount\PotentialIntermediateRailCalculator;
use Schletter\GroundMount\FinalRailCheck;

class RailCheckWith2ModulesTest extends \PHPUnit_Framework_TestCase 
{
    
    /**
     * Check #1
     */
    public function testLargestPotentialCenterRail() 
    {
        $cantilever = 65.9;
        $splicePercentage = .25;
        $span = 1981.2;
        $stockRail = 6200;
        $supportCount = 2;
        $potentialRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $systemLength = 2113;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $idealRail = ($systemLength <= $stockRail) ? $systemLength : $idealRail;
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength);
        $oppositeRailCheck = new EndRailCheckAgainstCantilever($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength);
        $railCheck = new RailCheck($idealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength);
        
        $actual = $railCheck->run();
        $expected = new RailSet(2113.0, 0, 5943.6, 0, 0.0, true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check #2
     */
    public function testNextLargestPotentialCenterRail() 
    {
        $cantilever = 65.9;
        $splicePercentage = .25;
        $span = 1981.2;
        $stockRail = 6200;
        $supportCount = 2;
        $potentialRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $systemLength = 2113;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $idealRail = ($systemLength <= $stockRail) ? $systemLength : $idealRail;
        $nextIdealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength, 1, $idealRail);
        $oppositeRailCheck = new EndRailCheckAgainstCantilever($cantilever, $splicePercentage, $span, $stockRail, $nextIdealRail, $systemLength);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength);
        $railCheck = new RailCheck($nextIdealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength);
        
        $actual = $railCheck->run();
        $expected = new RailSet(990.6, 0, 5943.6, 2, 561.2, true);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Check #3
     */
    public function testSecondToLargestPotentialCenterRail() 
    {
        $cantilever = 65.9;
        $splicePercentage = .25;
        $span = 1981.2;
        $stockRail = 6200;
        $supportCount = 2;
        $potentialRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $systemLength = 2113;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $idealRail = ($systemLength <= $stockRail) ? $systemLength : $idealRail;
        $nextIdealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength, 1, $idealRail);
        $secondToLastIdealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength, 2, $nextIdealRail);    
        $oppositeRailCheck = new EndRailCheckAgainstCantilever($cantilever, $splicePercentage, $span, $stockRail, $secondToLastIdealRail, $systemLength);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength);
        $railCheck = new RailCheck($secondToLastIdealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength);
        
        $actual = $railCheck->run();
        $expected = new RailSet(0, 0, 5943.6, 2, 1056.5, false);
        $this->assertEquals($expected, $actual);
    }
}
