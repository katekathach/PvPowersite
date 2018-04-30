<?php 

namespace Schletter\GroundMount\Test;

use Schletter\GroundMount\FormData;

class FormDataTest extends \PHPUnit_Framework_TestCase 
{
    public function testGetFormData()
    {
        $formData = new FormData();
        $expected = array(
            85 => array('code-version-5'),
            90 => array('code-version-5'),
            100 => array('code-version-5'),
            110 => array('code-version-5', 'code-version-10'),
            130 => array('code-version-5', 'code-version-10'),
            115 => array('code-version-10'),
            120 => array('code-version-5'),
            140 => array('code-version-10'),
            150 => array('code-version-10'),
            160 => array('code-version-10'),
        );
        
        $actual = $formData->getWindSpeeds();
        $this->assertEquals($expected, $actual);
    }
}
