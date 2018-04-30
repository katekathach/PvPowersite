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

class RailCheckTest extends \PHPUnit_Framework_TestCase 
{
    
    /**
     * Check #1
     */
    public function testLargestPotentialCenterRail() 
    {
        $cantilever = 739.7;
        $splicePercentage = .25;
        $span = 3200.4;
        $stockRail = 6200;
        $supportCount = 5;
        $potentialRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $systemLength = 14281;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength);
        $oppositeRailCheck = new EndRailCheckAgainstCantilever($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength);
        $railCheck = new RailCheck($idealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength);
        
        $actual = $railCheck->run();
        $expected = new RailSet(4800.6, 2, 3200.4, 2, 1539.8, false);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check #2
     */
    public function testNextLargestPotentialCenterRail() 
    {
        $cantilever = 739.7;
        $splicePercentage = .25;
        $span = 3200.4;
        $stockRail = 6200;
        $supportCount = 5;
        $potentialRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $systemLength = 14281;
        $nextIdealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength, 1);
        $oppositeRailCheck = new EndRailCheckAgainstCantilever($cantilever, $splicePercentage, $span, $stockRail, $nextIdealRail, $systemLength);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength);
        $railCheck = new RailCheck($nextIdealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength);
        
        $actual = $railCheck->run();
        $expected = new RailSet(1600.2, 2, 3200.4, 2, 3140, true);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Check #3
     */
    public function testSecondToLargestPotentialCenterRail() 
    {
        $cantilever = 739.7;
        $splicePercentage = .25;
        $span = 3200.4;
        $stockRail = 6200;
        $supportCount = 5;
        $potentialRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $systemLength = 14281;
        $secondToLastIdealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength, 2);    
        $oppositeRailCheck = new EndRailCheckAgainstCantilever($cantilever, $splicePercentage, $span, $stockRail, $secondToLastIdealRail, $systemLength);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength);
        $railCheck = new RailCheck($secondToLastIdealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength);
        
        $actual = $railCheck->run();
        $expected = new RailSet(0, 4, 3200.4, 2, 739.7, false);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Check #4 (== check #7)
     */
    public function testLargestPotentialEndRail() 
    {
        $cantilever = 739.7;
        $splicePercentage = .25;
        $span = 3200.4;
        $stockRail = 6200;
        $supportCount = 5;
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
        $expected = new RailSet(4800.6, 0, 3200.4, 2, 4740.2, false);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Check #5
     */
    public function testNextLargestPotentialEndRail()
    {
        $cantilever = 739.7;
        $splicePercentage = .25;
        $span = 3200.4;
        $stockRail = 6200;
        $supportCount = 5;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);
        $systemLength = 14281;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength, 1);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength);
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);        
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength);
        $railCheck = new RailCheck($idealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength, 'end');
        
        $actual = $railCheck->run();
        $expected = new RailSet(1600.2, 2, 3200.4, 2, 3140, true);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Check #6
     */
    public function testSmallestPotentialEndRail()
    {
        $cantilever = 739.7;
        $splicePercentage = .25;
        $span = 3200.4;
        $stockRail = 6200;
        $supportCount = 5;
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
        $expected = new RailSet(1600.2, 2, 3200.4, 2, 3140.0, true);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Check #8
     */
    public function testNextLargestIdealRemainingRailwithLargestEndRail()
    {
        $cantilever = 739.7;
        $splicePercentage = .25;
        $span = 3200.4;
        $stockRail = 6200;
        $supportCount = 5;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);
        $systemLength = 14281;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength);
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength, -2);
        $railCheck = new RailCheck($idealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength, 'end');
        
        $actual = $railCheck->run();
        $expected = new RailSet(4800.6, 0, 0, 0, 4740.2, false);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check #9
     */
    public function testSecondToLargestIdealRemainingRailwithLargestEndRail()
    {
        $cantilever = 739.7;
        $splicePercentage = .25;
        $span = 3200.4;
        $stockRail = 6200;
        $supportCount = 5;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);
        $systemLength = 14281;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength);
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength, -3);
        $railCheck = new RailCheck($idealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength, 'end');
        
        $actual = $railCheck->run();
        $expected = new RailSet(4800.6, 0, 0, 0, 4740.2, false);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Check #10
     */
    public function testFinalRailCheck()
    {
        $cantilever = 739.7;
        $splicePercentage = .25;
        $span = 3200.4;
        $stockRail = 6200;
        $supportCount = 5;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);
        $systemLength = 14281;
        $idealEndRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $finalRailCheck = new FinalRailCheck($systemLength, $stockRail, $potentialRailCalculator);
        
        $actual = $finalRailCheck->run();
        $expected = new RailSet(0.0, 0, 0.0, 0, 0, false);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Check #6
     */
    public function testRailForBrokenCheck()
    {
        $cantilever = 282.9;
        $splicePercentage = .25;
        $span = 1981.2;
        $stockRail = 6200;
        $supportCount = 7;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);
        $systemLength = 12453;
        $idealRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength, -1);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail($cantilever, $splicePercentage, $span, $stockRail, $idealRail, $systemLength);
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($stockRail, $systemLength, -1);
        $railCheck = new RailCheck($idealRail, $systemLength, $oppositeRailCheck, $idealRemainingRailLength, 'end');
        
        $actual = $railCheck->run();
        // The spreadsheet has a rounding error here that makes this check false, but it should be true.
        $expected = new RailSet(990.6, 4, 1981.2, 2, 1768.8, true);
        $this->assertEquals($expected, $actual);
    }
}
