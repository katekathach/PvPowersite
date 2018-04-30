<?php 

namespace Schletter\GroundMount;

abstract class PotentialRailCalculator
{
    protected $potentialRails = array();

    public function __construct($span, $supportCount, $splicePercentage, $cantilever = 0)
    {
        $this->potentialRails = $this->calculate($span, $supportCount, $splicePercentage, $cantilever);
    }

    /**
     * Get the largest potential rail that will work.
     * 
     * @param $previous int
     *   e.g., 0 = last, 1 = next to last, 2 = second to last
     *   Use negative numbers to move from the smallest (-1).
     * 
     * @param $max int
     *   The ideal rail can't be larger than $max.
     */
    public function getIdealRail($stockRail, $systemLength, $previous = 0, $max = null)
    {
        $idealRail = 0;
        /*if ($systemLength <= $stockRail) {
            $idealRail = $systemLength;
        } else {*/
            $possibleRails = array_filter($this->getRails(), function($rail) use ($stockRail) {
                return $rail <= $stockRail;
            });
            $idealRail = end($possibleRails);
            if ($previous > 0) {
                for ($i = 1; $i <= $previous; $i++) {
                    $idealRail = prev($possibleRails);
                }
                if ($max) {
                    while ($idealRail >= $max) {
                        $idealRail = prev($possibleRails);
                        if (false === $idealRail) {
                            break;   
                        }
                    } 
                }
            } elseif ($previous < 0) {
                $idealRail = reset($possibleRails);
                if ($previous < -1) {
                    for ($i = -2; $i >= $previous; $i--) {
                        $idealRail = next($possibleRails);
                    }
                }
            }
            // We're out of rails. e.g., Calculations!C56 
            if (false === $idealRail) {
                $idealRail = 0;   
            }
        //}

        return $idealRail;
    }

    public function getRails()
    {
        return $this->potentialRails;
    }

    protected abstract function calculate($span, $supportCount, $splicePercentage, $cantilever);
}
