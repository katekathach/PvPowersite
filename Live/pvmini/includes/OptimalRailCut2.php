<?php 

namespace Schletter\GroundMount;

use Schletter\GroundMount\OptimalRailCut;

class OptimalRailCut2 extends OptimalRailCut
{
    protected $stockRail = 2;
    
    protected function getRailCombinationMatrix()
    {
        $requiredRails = $this->stockRailCut->getRequiredRails();
        return array(
            1 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            2 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 1,
            ),
            3 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 2,
                'end-'.$requiredRails['end'] => 1,
            ),
            4 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 2,
            ),
            5 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            6 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 1,
            ),
            7 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            8 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            9 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 2,
            ),            
        );
    }
}
