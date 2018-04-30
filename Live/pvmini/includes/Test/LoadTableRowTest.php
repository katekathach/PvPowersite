<?php 

namespace Schletter\GroundMount\Test;

use Schletter\GroundMount\LoadTableRow;

class LoadTableRowTest extends \PHPUnit_Framework_TestCase 
{
    public function testGetData()
    {
        $parameters = array(
            'codeVersion' => 10,
            'cellType' => 60,
            'tilt' => 15,
            'wind' => 110,
            'snow' => 20,
            'seismic' => true,
        );
        
        $expected = array(
            'codeVersion' => '10',
            'cellType' => '60',
            'tilt' => '15',
            'wind' => '110',
            'snow' => '20',
            'seismic' => '1',
            'roofSnow' => '15.12',
            'maxSpan' => '8.75',
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
        );
        
        $loadTableRow = new LoadTableRow($parameters);
        $actual = $loadTableRow->getData();
        // We don't care about the ID matching.
        $expected['id'] = $actual['id'];
        
        $this->assertEquals($expected, $actual);
    }
}
