<?php 

namespace Schletter\GroundMount\Test;

use Schletter\GroundMount\Calculator;
use Schletter\GroundMount\PartsCalculator;

class PartsTest extends \PHPUnit_Framework_TestCase 
{
    public function testCalculateParts()
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
        $calculations = $calculator->getResultsWithLoadTables();
        $partsCalculator = new PartsCalculator($calculations);
        $actual = $partsCalculator->getParts();
        
        $expected = array(
            'rails' => array(
                array(
                    'partNumber' => '120008-06200',
                    'name' => '6.2 m ProfiPlus XT Rail',
                    'quantity' => 4,
                ),
            ),
            'splices' => array(
                array(
                    'partNumber' => '129006-000',
                    'name' => 'Splice, DN1, Internal, Kit',
                    'quantity' => 2,
                ),
            ),
            'supports' => array(
                array(
                    'partNumber' => '159003-003',
                    'name' => 'Standard, Triangle, PvMini, Assembly, 15&deg;',
                    'quantity' => 4,
                ),
            ),
            'endClamps' => array(
                array(
                    'partNumber' => '133180-280',
                    'name' => '8 mm Laminate Eco8 End Clamp Kit',
                    'quantity' => 4,
                ),
            ),
            'midClamps' => array(
                array(
                    'partNumber' => '133280-280',
                    'name' => '8 mm Laminate Eco8 Mid Clamp Kit',
                    'quantity' => 18,
                ),
            ),
            'braces' => array(
                array(
                    'partNumber' => '128003-002',
                    'name' => 'Cross Brace, PVMini, 60 Cell, Kit',
                    'quantity' => 1,
                ),
            ),
            'safetyHooks' => array(
                array(
                    'partNumber' => '139008-003',
                    'name' => '8mm Safety Hook',
                    'quantity' => 11,
                ),
            ),
        );
        
        $this->assertEquals($expected, $actual);
    }

    public function testCalculatePartsWithTilt20()
    {
        $parameters = array(
            'cellType' => 60,
            'moduleWidth' => 990,
            'moduleThickness' => 45,
            'tilt' => 20,
            'moduleColumns' => 40,
            'numberRacks' => 1,
            'codeVersion' => 5,
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
        $calculations = $calculator->getResultsWithLoadTables();
        $partsCalculator = new PartsCalculator($calculations);
        $actual = $partsCalculator->getParts();
        
        $expected = array(
            'rails' => array(
                array(
                    'partNumber' => '120004-06200',
                    'name' => '6.2 m ProfiPlus05 Rail',
                    'quantity' => 14,
                ),
            ),
            'splices' => array(
                array(
                    'partNumber' => '129074-000',
                    'name' => 'Splice, ProfiPlus, Internal, Kit, A',
                    'quantity' => 12,
                ),
            ),
            'supports' => array(
                array(
                    'partNumber' => '159003-004',
                    'name' => 'Standard, Triangle, PvMini, Assembly, 20&deg;',
                    'quantity' => 27,
                ),
            ),
            'endClamps' => array(
                array(
                    'partNumber' => '131001-045',
                    'name' => 'Rapid2+ End Clamp Assembly',
                    'quantity' => 4,
                ),
            ),
            'midClamps' => array(
                array(
                    'partNumber' => '135002-003',
                    'name' => 'Grounding Rapid 2+ Mid Clamp Assembly',
                    'quantity' => 78,
                ),
            ),
            'braces' => array(
                array(
                    'partNumber' => '128003-002',
                    'name' => 'Cross Brace, PVMini, 60 Cell, Kit',
                    'quantity' => 2,
                ),
            ),
            'safetyHooks' => array(),
        );
        
        $this->assertEquals($expected, $actual);
    }

    public function testCalculatePartsWithRackCount10()
    {
        $parameters = array(
            'cellType' => 60,
            'moduleWidth' => 990,
            'moduleThickness' => 45,
            'tilt' => 20,
            'moduleColumns' => 40,
            'numberRacks' => 10,
            'codeVersion' => 5,
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
        $calculations = $calculator->getResultsWithLoadTables();
        $partsCalculator = new PartsCalculator($calculations);
        $actual = $partsCalculator->getParts();
        
        $expected = array(
            'rails' => array(
                array(
                    'partNumber' => '120004-06200',
                    'name' => '6.2 m ProfiPlus05 Rail',
                    'quantity' => 140,
                ),
            ),
            'splices' => array(
                array(
                    'partNumber' => '129074-000',
                    'name' => 'Splice, ProfiPlus, Internal, Kit, A',
                    'quantity' => 120,
                ),
            ),
            'supports' => array(
                array(
                    'partNumber' => '159003-004',
                    'name' => 'Standard, Triangle, PvMini, Assembly, 20&deg;',
                    'quantity' => 270,
                ),
            ),
            'endClamps' => array(
                array(
                    'partNumber' => '131001-045',
                    'name' => 'Rapid2+ End Clamp Assembly',
                    'quantity' => 40,
                ),
            ),
            'midClamps' => array(
                array(
                    'partNumber' => '135002-003',
                    'name' => 'Grounding Rapid 2+ Mid Clamp Assembly',
                    'quantity' => 780,
                ),
            ),
            'braces' => array(
                array(
                    'partNumber' => '128003-002',
                    'name' => 'Cross Brace, PVMini, 60 Cell, Kit',
                    'quantity' => 20,
                ),
            ),
            'safetyHooks' => array(),
        );
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @group wip
     */
    public function testCalculatePartsWith68Thickness()
    {
        $parameters = array(
            'cellType' => 60,
            'moduleWidth' => 990,
            'moduleThickness' => 6.8,
            'tilt' => 20,
            'moduleColumns' => 40,
            'numberRacks' => 1,
            'codeVersion' => 5,
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
        $calculations = $calculator->getResultsWithLoadTables();
        $partsCalculator = new PartsCalculator($calculations);
        $actual = $partsCalculator->getParts();
        
        $expected = array(
            'rails' => array(
                array(
                    'partNumber' => '120004-06200',
                    'name' => '6.2 m ProfiPlus05 Rail',
                    'quantity' => 14,
                ),
            ),
            'splices' => array(
                array(
                    'partNumber' => '129074-000',
                    'name' => 'Splice, ProfiPlus, Internal, Kit, A',
                    'quantity' => 12,
                ),
            ),
            'supports' => array(
                array(
                    'partNumber' => '159003-004',
                    'name' => 'Standard, Triangle, PvMini, Assembly, 20&deg;',
                    'quantity' => 27,
                ),
            ),
            'endClamps' => array(
                array(
                    'partNumber' => '133160-268',
                    'name' => '6.8 mm Laminate Eco6 End Clamp Kit',
                    'quantity' => 4,
                ),
            ),
            'midClamps' => array(
                array(
                    'partNumber' => '133260-268',
                    'name' => '6.8 mm Laminate Eco6 Mid Clamp Kit',
                    'quantity' => 78,
                ),
            ),
            'braces' => array(
                array(
                    'partNumber' => '128003-002',
                    'name' => 'Cross Brace, PVMini, 60 Cell, Kit',
                    'quantity' => 2,
                ),
            ),
            'safetyHooks' => array(
                array(
                    'partNumber' => '139008-004',
                    'name' => '6.8mm Safety Hook',
                    'quantity' => 41,
                ),
            ),
        );
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @expectedException Schletter\GroundMount\Exception\NoLoadTableRowFoundException
     */
    public function testCalculateWithInvalidWind()
    {
        $parameters = array(
            'cellType' => 60,
            'moduleWidth' => 970,
            'moduleThickness' => 48,
            'tilt' => 15,
            'moduleColumns' => 40,
            'numberRacks' => 1,
            'codeVersion' => 10,
            'seismic' => false,
            'wind' => 85, // This wind speed is not available for ASCE 7-10.
            'snow' => 60,
            
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
        $calculations = $calculator->getResultsWithLoadTables();
    }
    
    public function testCalculateSplices()
    {
        $parameters = array(
            'cellType' => 60,
            'moduleWidth' => 975,
            'moduleThickness' => 36,
            'tilt' => 15,
            'moduleColumns' => 10,
            'numberRacks' => 1,
            'codeVersion' => 5,
            'seismic' => false,
            'wind' => 85,
            'snow' => 0,
            
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
        $calculations = $calculator->getResultsWithLoadTables();
        $partsCalculator = new PartsCalculator($calculations);
        $actual = $partsCalculator->getParts();
        
        $expected = array(
            'rails' => array(
                array(
                    'partNumber' => '120004-06200',
                    'name' => '6.2 m ProfiPlus05 Rail',
                    'quantity' => 4,
                ),
            ),
            'splices' => array(
                array(
                    'partNumber' => '129074-000',
                    'name' => 'Splice, ProfiPlus, Internal, Kit, A',
                    'quantity' => 2,
                ),
            ),
            'supports' => array(
                array(
                    'partNumber' => '159003-003',
                    'name' => 'Standard, Triangle, PvMini, Assembly, 15&deg;',
                    'quantity' => 4,
                ),
            ),
            'endClamps' => array(
                array(
                    'partNumber' => '131001-036',
                    'name' => 'Rapid2+ End Clamp Assembly',
                    'quantity' => 4,
                ),
            ),
            'midClamps' => array(
                array(
                    'partNumber' => '135002-002',
                    'name' => 'Grounding Rapid 2+ Mid Clamp Assembly',
                    'quantity' => 18,
                ),
            ),
            'braces' => array(
                array(
                    'partNumber' => '128003-002',
                    'name' => 'Cross Brace, PVMini, 60 Cell, Kit',
                    'quantity' => 1,
                ),
            ),
            'safetyHooks' => array(),
        );
        
        $this->assertEquals($expected, $actual);
    }
    
    public function testCalculateCrossBraces()
    {
        $parameters = array(
            'cellType' => 60,
            'moduleWidth' => 1046,
            'moduleThickness' => 46,
            'tilt' => 35,
            'moduleColumns' => 40,
            'numberRacks' => 1,
            'codeVersion' => 5,
            'seismic' => true,
            'wind' => 85,
            'snow' => 60,
            
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
        $calculations = $calculator->getResultsWithLoadTables();
        $partsCalculator = new PartsCalculator($calculations);
        $actual = $partsCalculator->getParts();
        
        $expected = array(
            'rails' => array(
                array(
                    'partNumber' => '120008-06200',
                    'name' => '6.2 m ProfiPlus XT Rail',
                    'quantity' => 19,
                ),
                array(
                    'partNumber' => '120008-04200',
                    'name' => '4.2 m ProfiPlus XT Rail',
                    'quantity' => 0,
                ),
            ),
            'splices' => array(
                array(
                    'partNumber' => '129006-000',
                    'name' => 'Splice, DN1, Internal, Kit',
                    'quantity' => 20,
                ),
            ),
            'supports' => array(
                array(
                    'partNumber' => '159003-007',
                    'name' => 'Standard, Triangle, PvMini, Assembly, 35&deg;',
                    'quantity' => 21,
                ),
            ),
            'endClamps' => array(
                array(
                    'partNumber' => '131001-046',
                    'name' => 'Rapid2+ End Clamp Assembly',
                    'quantity' => 4,
                ),
            ),
            'midClamps' => array(
                array(
                    'partNumber' => '135002-003',
                    'name' => 'Grounding Rapid 2+ Mid Clamp Assembly',
                    'quantity' => 78,
                ),
            ),
            'braces' => array(
                array(
                    'partNumber' => '128003-002',
                    'name' => 'Cross Brace, PVMini, 60 Cell, Kit',
                    'quantity' => 3,
                ),
            ),
            'safetyHooks' => array(),
        );
        
        $this->assertEquals($expected, $actual);
    }
    
}
