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

class RailCheck10Test extends \PHPUnit_Framework_TestCase 
{
    /**
     * Check #10
     */
    public function testFinalRailCheck()
    {
        $cantilever = 606.6;
        $splicePercentage = .25;
        $span = 1752.6;
        $stockRail = 6200;
        $supportCount = 4;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);
        $systemLength = 6471;
        $idealEndRail = $potentialRailCalculator->getIdealRail($stockRail, $systemLength);
        $finalRailCheck = new FinalRailCheck($systemLength, $stockRail, $potentialRailCalculator);
        
        $actual = $finalRailCheck->run();
        $expected = new RailSet(1921.05, 1, 4549.95, 0, 0, true);
        $this->assertEquals($expected, $actual);
    }
    
}
