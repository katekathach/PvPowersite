<?php 

namespace Schletter\GroundMount\Test;

use Schletter\GroundMount\PotentialCenterRailCalculator;
use Schletter\GroundMount\PotentialEndRailCalculator;
use Schletter\GroundMount\PotentialIntermediateRailCalculator;

class PotentialRailCalculatorTest extends \PHPUnit_Framework_TestCase 
{
  
    public function testPotentialCenterRailCalculationWithOddSupportCount()
    {
        $span = 3200.4; // 10.5 ft
        $supportCount = 5;
        $splicePercentage = .25;
        $potentialRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $expected = array(
            1  => 1600.2,
            2  => 4800.6,
            3  => 8001.0,
            4  => 11201.4,
            5  => 14401.8,
            6  => 17602.2,
            7  => 20802.6,
            8  => 24003.0,
            9  => 27203.4,
            10 => 30403.8,
            11 => 33604.2,
            12 => 36804.6,
            13 => 40005.0,
            14 => 43205.4,
            15 => 46405.8,
        );
        $this->assertEquals($expected, $potentialRailCalculator->getRails());
    }

    public function testPotentialCenterRailCalculationWithEvenSupportCount()
    {
        $span = 3657.6; // 12 ft
        $supportCount = 4;
        $splicePercentage = .25;
        $potentialRailCalculator = new PotentialCenterRailCalculator($span, $supportCount, $splicePercentage);
        $expected = array(
            1  => 1828.8,			
            2  => 5486.4,
            3  => 9144.0,
            4  => 12801.6,
            5  => 16459.2,
            6  => 20116.8,
            7  => 23774.4,
            8  => 27432.0,
            9  => 31089.6,
            10 => 34747.2,
            11 => 38404.8,
            12 => 42062.4,
            13 => 45720.0,
            14 => 49377.6,
            15 => 53035.2,
        );
        $this->assertEquals($expected, $potentialRailCalculator->getRails());
    }

    public function testPotentialIntermediateRailCalculationWithOddSupportCount()
    {
        $span = 3200.4; // 10.5 ft
        $supportCount = 5;
        $splicePercentage = .25;
        $potentialRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $expected = array(
            1  => 3200.4,
            2  => 6400.8,
            3  => 9601.2,
            4  => 12801.6,
            5  => 16002.0,	
            6  => 19202.4,
            7  => 22402.8,
            8  => 25603.2,	
            9  => 28803.6,
            10 => 32004.0,
            11 => 35204.4,
            12 => 38404.8,
            13 => 41605.2,
            14 => 44805.6,
            15 => 48006.0,
        );
        $this->assertEquals($expected, $potentialRailCalculator->getRails());
    }

    public function testPotentialIntermediateRailCalculationWithEvenSupportCount()
    {
        $span = 3657.6; // 12 ft
        $supportCount = 4;
        $splicePercentage = .25;
        $potentialRailCalculator = new PotentialIntermediateRailCalculator($span, $supportCount, $splicePercentage);
        $expected = array(
            1  => 1828.8,			
            2  => 3657.6,
            3  => 5486.4,
            4  => 7315.2,
            5  => 9144.0,
            6  => 10972.8,
            7  => 12801.6,
            8  => 14630.4,
            9  => 16459.2,
            10 => 18288.0,
            11 => 20116.8,
            12 => 21945.6,
            13 => 23774.4,
            14 => 25603.2,
            15 => 27432.0,
        );
        $this->assertEquals($expected, $potentialRailCalculator->getRails());
    }

    public function testPotentialEndRailCalculationWithOddSupportCount()
    {
        $span = 3200.4; // 10.5 ft
        $supportCount = 5;
        $splicePercentage = .25;
        $cantilever = 739.7;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);
        
        $expected = array(
            0  => 3140.0,
            1  => 4740.2,
            2  => 6340.4,	
            3  => 7940.6,
            4  => 9540.8,									
            5  => 11141.0,	
            6  => 12741.2,
            7  => 14341.4,
            8  => 15941.6,	
            9  => 17541.8,
            10 => 19142.0,
            11 => 20742.2,
            12 => 22342.4,
            13 => 23942.6,
            14 => 25542.8,
        );
        $this->assertEquals($expected, $potentialRailCalculator->getRails());
    }

    public function testPotentialEndRailCalculationWithEvenSupportCount()
    {
        $span = 3657.6; // 12 ft
        $supportCount = 4;
        $splicePercentage = .25;
        $cantilever = 1654.1;
        $potentialRailCalculator = new PotentialEndRailCalculator($span, $supportCount, $splicePercentage, $cantilever);

        $expected = array(
            0  => 4397.3,
            1  => 6226.1,
            2  => 8054.9,														
            3  => 9883.7,
            4  => 11712.5,
            5  => 13541.3,
            6  => 15370.1,
            7  => 17198.9,
            8  => 19027.7,
            9  => 20856.5,
            10 => 22685.3,
            11 => 24514.1,
            12 => 26342.9,
            13 => 28171.7,
            14 => 30000.5,
        );
        $this->assertEquals($expected, $potentialRailCalculator->getRails());
    }
}
