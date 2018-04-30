<?php 

namespace Schletter\GroundMount\Test;

use Schletter\GroundMount\StockRailCut;
use Schletter\GroundMount\OptimalRailCut1;
use Schletter\GroundMount\OptimalRailCut2;
use Schletter\GroundMount\OptimalRailCut3;
use Schletter\GroundMount\OptimalRailCut4;
use Schletter\GroundMount\OptimalRailCut5;

class RailCutTest extends \PHPUnit_Framework_TestCase 
{
    protected $railCut;
    
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
            'center' => 1600,
            'intermediate' => 3200,
            'end' => 3140,
        );
        $requiredQuantities = array(
            'center' => 4, 
            'intermediate' => 8, 
            'end' => 8,
        );
        $this->stockRailCut = new StockRailCut($stockRails, $requiredRails, $requiredQuantities);
        $this->optimalRailCut1 = new OptimalRailCut1($this->stockRailCut);
        $this->optimalRailCut2 = new OptimalRailCut2($this->stockRailCut);
        $this->optimalRailCut3 = new OptimalRailCut3($this->stockRailCut);        
        $this->optimalRailCut4 = new OptimalRailCut4($this->stockRailCut);        
        $this->optimalRailCut5 = new OptimalRailCut5($this->stockRailCut);        
    }
    
    public function testBestStockCut()
    {
        $expected = array(
            'railsShipping' => 18,
            'totalShippingLength' => 79600,
            'wasteLength' => 22480,
            'wastePercentage' => .2824,
            'fromStock' => array(
                'center' => 3.0,
                'intermediate' => 1.0,
                'end' => 1.0,
            ),
            'choose' => array(
                'center' => 6200,
                'intermediate' => 4200,
                'end' => 4200,
            ),
            'totalRequiredLength' => 57120,
            'instructions' => array(
                1 => '',
                2 => 'Cut (6) 1600mm rail(s) from (2) 6200mm stock rails.',
                3 => 'Cut (8) 3200mm rail(s) from (8) 4200mm stock rails.',
                4 => 'Cut (8) 3140mm rail(s) from (8) 4200mm stock rails.',
            ),
            'stockRailQuantity' => array(
                4200 => 16,
                6200 => 2,
            ),
        );
        $actual = $this->stockRailCut->getMostEfficientRails();
        $this->assertEquals($expected, $actual);
    }
    
    public function testBestOptimalCut1()
    {
        $expected = array(
            'railsShipping' => 16,
            'totalShippingLength' => 75200,
            'wasteLength' => 18080,
            'wastePercentage' => .24,
            'instructions' => array(
                1 => 'Cut (4) 1600mm rail(s) &amp; (4) 3200mm rail(s) from (4) 6200mm stock rails.',
                2 => '',
                3 => 'Cut (4) 3200mm rail(s) from (4) 4200mm stock rails.',
                4 => 'Cut (8) 3140mm rail(s) from (8) 4200mm stock rails.',
            ),
            'stockRailQuantity' => array(
                4200 => 12,
                6200 => 4,
            ),
        );
        $actual = $this->optimalRailCut1->getMostEfficientRails();
        $this->assertEquals($expected, $actual);
    }

    public function testBestOptimalCut2()
    {
        $expected = array(
            'railsShipping' => 16,
            'totalShippingLength' => 75200,
            'wasteLength' => 18080,
            'wastePercentage' => .24,
            'instructions' => array(
                1 => 'Cut (4) 1600mm rail(s) &amp; (4) 3200mm rail(s) from (4) 6200mm stock rails.',
                2 => '',
                3 => 'Cut (4) 3200mm rail(s) from (4) 4200mm stock rails.',
                4 => 'Cut (8) 3140mm rail(s) from (8) 4200mm stock rails.',
            ),
            'stockRailQuantity' => array(
                4200 => 12,
                6200 => 4,
            ),
        );
        $actual = $this->optimalRailCut2->getMostEfficientRails();
        $this->assertEquals($expected, $actual);
    }

    public function testBestOptimalCut3()
    {
        $expected = array(
            'railsShipping' => 18,
            'totalShippingLength' => 79600,
            'wasteLength' => 22480,
            'wastePercentage' => .28,
            'instructions' => array(
                1 => '',
                2 => 'Cut (6) 1600mm rail(s) from (2) 6200mm stock rails.',
                3 => 'Cut (8) 3200mm rail(s) from (8) 4200mm stock rails.',
                4 => 'Cut (8) 3140mm rail(s) from (8) 4200mm stock rails.',
            ),
            'stockRailQuantity' => array(
                4200 => 16,
                6200 => 2,
            ),
        );
        $actual = $this->optimalRailCut3->getMostEfficientRails();
        $this->assertEquals($expected, $actual);
    }

    public function testBestOptimalCut4()
    {
        $expected = array(
            'railsShipping' => 18,
            'totalShippingLength' => 79600,
            'wasteLength' => 22480,
            'wastePercentage' => .28,
            'instructions' => array(
                1 => '',
                2 => 'Cut (6) 1600mm rail(s) from (2) 6200mm stock rails.',
                3 => 'Cut (8) 3200mm rail(s) from (8) 4200mm stock rails.',
                4 => 'Cut (8) 3140mm rail(s) from (8) 4200mm stock rails.',
            ),
            'stockRailQuantity' => array(
                4200 => 16,
                6200 => 2,
            ),
        );
        $actual = $this->optimalRailCut4->getMostEfficientRails();
        $this->assertEquals($expected, $actual);
    }

    public function testBestOptimalCut5()
    {
        $expected = array(
            'railsShipping' => 18,
            'totalShippingLength' => 79600,
            'wasteLength' => 22480,
            'wastePercentage' => .28,
            'instructions' => array(
                1 => '',
                2 => 'Cut (6) 1600mm rail(s) from (2) 6200mm stock rails.',
                3 => 'Cut (8) 3200mm rail(s) from (8) 4200mm stock rails.',
                4 => 'Cut (8) 3140mm rail(s) from (8) 4200mm stock rails.',
            ),
            'stockRailQuantity' => array(
                4200 => 16,
                6200 => 2,
            ),
        );
        $actual = $this->optimalRailCut5->getMostEfficientRails();
        $this->assertEquals($expected, $actual);
    }
}

