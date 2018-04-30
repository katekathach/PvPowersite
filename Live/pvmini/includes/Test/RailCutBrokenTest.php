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

class RailCheckBrokenTest extends \PHPUnit_Framework_TestCase 
{
    
    /**
     * Check #1
     */
    public function testLargestPotentialCenterRail() 
    {
        $cantilever = 663.5;
        $splicePercentage = .25;
        $span = 2590.8;
        $stockRail = 6200;
        $supportCount = 6;
        $potentialRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $systemLength = 14281;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength);
        $oppositeRailCheck = new EndRailCheckAgainstCantilever($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength);
        $railCheck = new RailCheck($idealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength);
        
        $actual = $railCheck->run();
        $expected = new RailSet(3886.2, 2, 5181.6, 2, 15.8, false);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Check #4 (== check #7)
     */
    public function testLargestPotentialEndRail() 
    {
        $cantilever = 663.5;
        $splicePercentage = .25;
        $span = 2590.8;
        $stockRail = 6200;
        $supportCount = 6;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);
        $systemLength = 14281;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength);
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength);
        $railCheck = new RailCheck($idealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength, 'end');
        
        $actual = $railCheck->run();
        $expected = new RailSet(3886.2, 0, 5181.6, 2, 5197.4, false);
        $this->assertEquals($expected, $actual);
    }    
    
    /**
     * Check #6
     */
    public function testSmallestPotentialEndRail()
    {
        $cantilever = 663.5;
        $splicePercentage = .25;
        $span = 2590.8;
        $stockRail = 6200;
        $supportCount = 6;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);
        $systemLength = 14281;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength, -1);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength);
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength, -1);
        $railCheck = new RailCheck($idealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength, 'end');
        
        $actual = $railCheck->run();
        $expected = new RailSet(1295.4, 6, 1295.4, 2, 2606.6, true);
        $this->assertEquals($expected, $actual);
    }
    
}

