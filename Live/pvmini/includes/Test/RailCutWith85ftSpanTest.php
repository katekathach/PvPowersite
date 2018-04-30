<?php 

namespace Schletter\GroundMount\Test;

use Schletter\GroundMount\StockRailCut;
use Schletter\GroundMount\OptimalRailCut1;
use Schletter\GroundMount\OptimalRailCut2;
use Schletter\GroundMount\OptimalRailCut3;
use Schletter\GroundMount\OptimalRailCut4;
use Schletter\GroundMount\OptimalRailCut5;

class RailCutWith85ftSpanTest extends \PHPUnit_Framework_TestCase 
{
    protected $stockRailCut;
    protected $optimalRailCut4;
    
    protected function setUp()
    {
        $stockRails = array(
            1 => 6200,
            2 => 6200,
            3 => 4200,
            4 => 4200,
            5 => 4200,
        );
        $requiredRails = array(
            'center' => 1300,
            'intermediate' => 1300,
            'end' => 2610,
        );
        $requiredQuantities = array(
            'center' => 2, 
            'intermediate' => 12, 
            'end' => 4,
        );
        $this->stockRailCut = new StockRailCut($stockRails, $requiredRails, $requiredQuantities);
        $this->optimalRailCut4 = new OptimalRailCut4($this->stockRailCut);                
    }

    public function testBestOptimalCut4()
    {
        $expected = array(
            'railsShipping' => 7,
            'totalShippingLength' => 31400,
            'wasteLength' => 2760,
            'wastePercentage' => .09,
            'instructions' => array(
                1 => 'Cut (2) 1300mm rail(s) &amp; (2) 2610mm rail(s) from (2) 4200mm stock rails.',
                2 => '',
                3 => 'Cut (12) 1300mm rail(s) from (4) 4200mm stock rails.',
                4 => 'Cut (2) 2610mm rail(s) from (1) 6200mm stock rails.',
            ),
            'stockRailQuantity' => array(
                4200 => 6,
                6200 => 1,
            ),
        );
        $actual = $this->optimalRailCut4->getMostEfficientRails();
        $this->assertEquals($expected, $actual);
    }
}

