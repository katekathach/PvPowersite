<?php 

namespace Schletter\GroundMount\Test;

use Schletter\GroundMount\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase 
{
    public function testCalculateWithLoadTables()
    {
        $parameters = array(
            'cellType' => 60,
            'moduleWidth' => 993,
            'moduleThickness' => 8,
            'tilt' => 15,
            'moduleColumns' => 10,
            'numberRacks' => 1,
            'codeVersion' => 10,
            'seismic' => true,
            'wind' => 110,
            'snow' => 20,
            
            'moduleHeight' => 1700,
            'orientation' => 'portrait',
            'moduleRows' => 1,
            'moduleClampLocation' => .25,
            'splicePercentage' => .25,
            'maxRail' => 6200,
            'minRail' => 4200,
            'tolerance' => 40,
        );
        
        $calculator = new Calculator($parameters);
        $actual = $calculator->getResultsWithLoadTables();

        $expected = array(
            'centerRailLength' => 4440.0,
            'centerRailCount' => 1,
            'intermediateRailLength' => 5780.0,
            'intermediateRailCount' => 1,
            'endRailLength' => 0.0,
            'endRailCount' => 0,
            'railsPerRow' => 2,
            'railLength' => 6200.0,
            'railsShipping' => 4,
            'spliceCount' => 2,
            'confirmation' => 'Confirmed (3mm)',
            'instructions' => array(
                1 => '',
                2 => 'Cut (2) 4440mm rail(s) from (2) 6200mm stock rails.',
                3 => 'Cut (2) 5780mm rail(s) from (2) 6200mm stock rails.',
                4 => '',
                5 => 'with 17.58% [4360mm] of 24800mm wasted',
            ),
            'stockRailQuantity' => array(
                4200 => 0,
                6200 => 4,
            ),
            'cellType' => 60,
            'moduleWidth' => 993,
            'moduleColumns' => 10,
            'systemLength' => 10217,
            'codeVersion' => 10,
            'tilt' => 15,
            'wind' => 110,
            'snow' => 20,
            'seismic' => true,
            'roofSnow' => '15.12',
            'purlinType' => 'ProfiPlusXT',
            'FCT' => 0.5,
            'FCC' => 1.83,
            'FCS' => 0.05,
            'RCT' => 1.55,
            'RCC' => 1.34,
            'RCS' => 0.58,
            'brace' => '10',
            'ballastWidth' => '21',
            'rebarCount' => 1,
            'purlin' => '0.8',
            'girder' => '0.38',
            'strut' => '0.17',
            'drift' => '0.23',
            'fasteners' => '0.98',
            'moduleThickness' => 8,
            'numberRacks' => 1,
            'moduleHeight' => 1700,
            'orientation' => 'portrait',
            'moduleRows' => 1,
            'moduleClampLocation' => .25,
            'splicePercentage' => .25,
            'maxRail' => 6200,
            'minRail' => 4200,
            'tolerance' => 40,
            'maxSpan' => 8.75,
        );
        
        // We don't care about the ID matching.
        $expected['id'] = $actual['id'];
        
        $this->assertEquals($expected, $actual);
    }

    public function testCalculate() 
    {
        $parameters = array(
            'moduleHeight' => 1700,
            'moduleWidth' => 993,
            'orientation' => 'portrait',
            'moduleRows' => 1,
            'moduleCount' => 14,
            'moduleClampLocation' => .25,
            'spanInFt' => 10.5,
            'splicePercentage' => .25,
            'maxRail' => 6200,
            'minRail' => 4200,
            'tolerance' => 40,
        );
        
        $calculator = new Calculator($parameters);
        $actual = $calculator->getResults();

        $expected = array(
            'centerRailLength' => 1600.0,
            'centerRailCount' => 1,
            'intermediateRailLength' => 3200.0,
            'intermediateRailCount' => 2,
            'endRailLength' => 3140.0,
            'endRailCount' => 2,
            'railsPerRow' => 5,
            'railLength' => 6200.0,
            'railsShipping' => 8,
            'spliceCount' => 8,
            'confirmation' => 'Confirmed (-1mm)',
            'instructions' => array(
                1 => 'Cut (2) 1600mm rail(s) &amp; (2) 3200mm rail(s) from (2) 6200mm stock rails.',
                2 => '',
                3 => 'Cut (2) 3200mm rail(s) from (2) 4200mm stock rails.',
                4 => 'Cut (4) 3140mm rail(s) from (4) 4200mm stock rails.',
                5 => 'with 24% [9040mm] of 37600mm wasted',
            ),
            'stockRailQuantity' => array(
                4200 => 6,
                6200 => 2,
            ),
        );
        
        $this->assertEquals($expected, $actual);
    }
    
    public function testCalculateWith85ftspan() 
    {
        $parameters = array(
            'moduleHeight' => 1700,
            'moduleWidth' => 993,
            'orientation' => 'portrait',
            'moduleRows' => 1,
            'moduleCount' => 14,
            'moduleClampLocation' => .25,
            'spanInFt' => 8.5,
            'splicePercentage' => .25,
            'maxRail' => 6200,
            'minRail' => 4200,
            'tolerance' => 40,
        );
        
        $calculator = new Calculator($parameters);
        $actual = $calculator->getResults();

        $expected = array(
            'centerRailLength' => 1300.0,
            'centerRailCount' => 1,
            'intermediateRailLength' => 1300.0,
            'intermediateRailCount' => 6,
            'endRailLength' => 2610.0,
            'endRailCount' => 2,
            'railsPerRow' => 9,
            'railLength' => 6200.0,
            'railsShipping' => 7,
            'spliceCount' => 16,
            'confirmation' => 'Confirmed (39mm)',
            'instructions' => array(
                1 => 'Cut (2) 1300mm rail(s) &amp; (2) 2610mm rail(s) from (2) 4200mm stock rails.',
                2 => '',
                3 => 'Cut (12) 1300mm rail(s) from (4) 4200mm stock rails.',
                4 => 'Cut (2) 2610mm rail(s) from (1) 6200mm stock rails.',
                5 => 'with 9% [2760mm] of 31400mm wasted',
            ),
            'stockRailQuantity' => array(
                4200 => 6,
                6200 => 1,
            ),
        );
        
        $this->assertEquals($expected, $actual);
    }
    
    public function testWeirdRailCuts() 
    {
        $parameters = array(
            'moduleHeight' => 1700,
            'moduleWidth' => 1010,
            'orientation' => 'portrait',
            'moduleRows' => 1,
            'moduleCount' => 12,
            'moduleClampLocation' => .25,
            'spanInFt' => 6.5,
            'splicePercentage' => .25,
            'maxRail' => 6200,
            'minRail' => 4200,
            'tolerance' => 40,
        );
        
        $calculator = new Calculator($parameters);
        $actual = $calculator->getResults();

        $expected = array(
            'centerRailLength' => 4950.0,
            'centerRailCount' => 1,
            'intermediateRailLength' => 0.0,
            'intermediateRailCount' => 0,
            'endRailLength' => 3750.0,
            'endRailCount' => 2,
            'railsPerRow' => 3,
            'railLength' => 6200.0,
            'railsShipping' => 6,
            'spliceCount' => 4,
            'confirmation' => 'Confirmed (-3mm)',
            'instructions' => array(
                1 => '',
                2 => 'Cut (2) 4950mm rail(s) from (2) 6200mm stock rails.',
                3 => '',
                4 => 'Cut (4) 3750mm rail(s) from (4) 4200mm stock rails.',
                5 => 'with 14.73% [4300mm] of 29200mm wasted',
            ),
            'stockRailQuantity' => array(
                4200 => 4,
                6200 => 2,
            ),
        );
        
        $this->assertEquals($expected, $actual);
    }    
    
    public function testForBlakeTest4()
    {
        $parameters = array(
            'moduleHeight' => 1700,
            'moduleWidth' => 1040,
            'orientation' => 'portrait',
            'moduleRows' => 1,
            'moduleCount' => 16,
            'moduleClampLocation' => .25,
            'spanInFt' => 6.5,
            'splicePercentage' => .25,
            'maxRail' => 6200,
            'minRail' => 4200,
            'tolerance' => 40,
        );
        
        $calculator = new Calculator($parameters);
        $actual = $calculator->getResults();

        $expected = array(
            'centerRailLength' => 990.0,
            'centerRailCount' => 1,
            'intermediateRailLength' => 5940.0,
            'intermediateRailCount' => 2,
            'endRailLength' => 2090.0,
            'endRailCount' => 2,
            'railsPerRow' => 5,
            'railLength' => 6200.0,
            'railsShipping' => 6,
            'spliceCount' => 8,
            'confirmation' => 'Confirmed (-15mm)',
            'instructions' => array(
                1 => 'Cut (2) 990mm rail(s) &amp; (4) 2090mm rail(s) from (2) 6200mm stock rails.',
                2 => '',
                3 => 'Cut (4) 5940mm rail(s) from (4) 6200mm stock rails.',
                4 => '',
                5 => 'with 8% [3100mm] of 37200mm wasted',
            ),
            'stockRailQuantity' => array(
                4200 => 0,
                6200 => 6,
            ),
        );
        
        $this->assertEquals($expected, $actual);
    }

    public function testOnly2Modules()
    {
        $parameters = array(
            'moduleHeight' => 1700,
            'moduleWidth' => 1005,
            'orientation' => 'portrait',
            'moduleRows' => 1,
            'moduleCount' => 2,
            'moduleClampLocation' => .25,
            'spanInFt' => 6.5,
            'splicePercentage' => .25,
            'maxRail' => 6200,
            'minRail' => 4200,
            'tolerance' => 40,
        );
        
        $calculator = new Calculator($parameters);
        $actual = $calculator->getResults();

        $expected = array(
            'centerRailLength' => 2110.0,
            'centerRailCount' => 1,
            'intermediateRailLength' => 0.0,
            'intermediateRailCount' => 0,
            'endRailLength' => 0.0,
            'endRailCount' => 0,
            'railsPerRow' => 1,
            'railLength' => 6200.0,
            'railsShipping' => 1,
            'spliceCount' => 0,
            'confirmation' => 'Confirmed (-3mm)',
            'instructions' => array(
                1 => '',
                2 => 'Cut (2) 2110mm rail(s) from (1) 6200mm stock rails.',
                3 => '',
                4 => '',
                5 => 'with 31.94% [1980mm] of 6200mm wasted',
            ),
            'stockRailQuantity' => array(
                4200 => 0,
                6200 => 1,
            ),
        );
        
        $this->assertEquals($expected, $actual);        
    }
    
    public function testCheck10()
    {
        $parameters = array(
            'moduleHeight' => 1700,
            'moduleWidth' => 1046,
            'orientation' => 'portrait',
            'moduleRows' => 1,
            'moduleCount' => 6,
            'moduleClampLocation' => .25,
            'spanInFt' => 5.75,
            'splicePercentage' => .25,
            'maxRail' => 6200,
            'minRail' => 4200,
            'tolerance' => 40,
        );
        
        $calculator = new Calculator($parameters);
        $actual = $calculator->getResults();

        $expected = array(
            'centerRailLength' => 1920.0,
            'centerRailCount' => 1,
            'intermediateRailLength' => 4550.0,
            'intermediateRailCount' => 1,
            'endRailLength' => 0.0,
            'endRailCount' => 0,
            'railsPerRow' => 2,
            'railLength' => 6200.0,
            'railsShipping' => 3,
            'spliceCount' => 2, 
            'confirmation' => 'Confirmed (-1mm)',
            'instructions' => array(
                1 => '',
                2 => 'Cut (3) 1920mm rail(s) from (1) 6200mm stock rails.',
                3 => 'Cut (2) 4550mm rail(s) from (2) 6200mm stock rails.',
                4 => '',
                5 => 'with 30.43% [5660mm] of 18600mm wasted',
            ),
            'stockRailQuantity' => array(
                4200 => 0,
                6200 => 3,
            ),
        );
        
        $this->assertEquals($expected, $actual);        
    }
}
