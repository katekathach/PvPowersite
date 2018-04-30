<?php 

namespace Schletter\GroundMount;

use Schletter\GroundMount\OptimalRailCut;

class OptimalRailCut3 extends OptimalRailCut
{
    protected $stockRail = 3;
    
    protected function getRailCombinationMatrix()
    {
        $requiredRails = $this->stockRailCut->getRequiredRails();
        return array(
            1 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            2 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            3 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            4 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 1,
            ),
            5 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 2,
                'end-'.$requiredRails['end'] => 1,
            ),
            6 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 2,
            ),
            7 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            8 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 0,
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
