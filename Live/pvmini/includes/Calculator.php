<?php

namespace Schletter\GroundMount;

use Schletter\GroundMount\RailCheck;
use Schletter\GroundMount\RailSet;
use Schletter\GroundMount\EndRailCheckAgainstCantilever;
use Schletter\GroundMount\CenterRailCheckAgainstStockRail;
use Schletter\GroundMount\PotentialCenterRailCalculator;
use Schletter\GroundMount\PotentialEndRailCalculator;
use Schletter\GroundMount\PotentialIntermediateRailCalculator;
use Schletter\GroundMount\FinalRailCheck;
use Schletter\GroundMount\RailCut;
use Schletter\GroundMount\LoadTableRow;

class Calculator
{
    protected $parameters = array();
    
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getResultsWithLoadTables()
    {
        $parameters = array(
            'codeVersion' => $this->parameters['codeVersion'],
            'cellType' => $this->parameters['cellType'],
            'tilt' => $this->parameters['tilt'],
            'wind' => $this->parameters['wind'],
            'snow' => $this->parameters['snow'],
            'seismic' => $this->parameters['seismic'],
        );
        
        $loadTableRow = new LoadTableRow($parameters);
        $loadTableData = $loadTableRow->getData();

        $this->parameters['spanInFt'] = $loadTableData['maxSpan'];
        $this->parameters['moduleCount'] = $this->parameters['moduleRows'] * $this->parameters['moduleColumns'];
        
        $results = $this->getResults();
        $results = array_merge($results, $loadTableData);
        $results['cellType'] = $this->parameters['cellType'];
        $results['moduleWidth'] = $this->parameters['moduleWidth'];
        $results['moduleColumns'] = $this->parameters['moduleColumns'];        
        $results['systemLength'] = $this->parameters['systemLength'];        
        $results['codeVersion'] = $this->parameters['codeVersion'];        
        $results['tilt'] = $this->parameters['tilt'];        
        $results['wind'] = $this->parameters['wind'];        
        $results['snow'] = $this->parameters['snow'];        
        $results['seismic'] = $this->parameters['seismic'];        
        $results['moduleThickness'] = $this->parameters['moduleThickness'];        
        $results['numberRacks'] = $this->parameters['numberRacks'];        
        $results['moduleHeight'] = $this->parameters['moduleHeight'];        
        $results['orientation'] = $this->parameters['orientation'];        
        $results['moduleRows'] = $this->parameters['moduleRows'];        
        $results['moduleClampLocation'] = $this->parameters['moduleClampLocation'];        
        $results['splicePercentage'] = $this->parameters['splicePercentage'];        
        $results['maxRail'] = $this->parameters['maxRail'];        
        $results['minRail'] = $this->parameters['minRail'];        
        $results['tolerance'] = $this->parameters['tolerance'];        
        
        return $results;
    }

    public function getResults()
    {
        $results = array(
            'centerRailLength' => 0.0,
            'centerRailCount' => 0,
            'intermediateRailLength' => 0.0,
            'intermediateRailCount' => 0,
            'endRailLength' => 0.0,
            'endRailCount' => 0,
            'railsPerRow' => 0,
            'railLength' => 0.0,
            'railsShipping' => 0,
            'spliceCount' => 0,
            'confirmation' => '',
        );
        
        extract($this->parameters);

        $this->parameters['span'] = $spanInFt * 304.8;
        if ('landscape' === $orientation) {
            $systemLength = $moduleHeight * $moduleCount + 5 * ($moduleCount - 1) - 
                $moduleHeight * $moduleClampLocation * 2 + 2 * $tolerance;
        } else {
            $systemLength = $moduleWidth * $moduleCount + 23 * ($moduleCount - 1) + 2 * $tolerance;
        }
        
        $this->parameters['systemLength'] = $systemLength;
        $this->parameters['stockRail'] = $maxRail;
        $systemLengthInFt = $systemLength / 304.8;
        $this->parameters['supportCount'] = max(ceil($systemLengthInFt / $spanInFt), 2);
        $spanCount = $this->parameters['supportCount'] - 1;
        $spanTotal = $spanCount * $spanInFt;
        $cantileverPercentage = ($systemLengthInFt - $spanTotal) / $spanInFt / 2;
        $cantileverInFt = $cantileverPercentage * $spanInFt;
        $this->parameters['cantilever'] = $cantileverInFt * 304.8;
        
        $bestRailSet = $this->findBestRailSet();
        $supportCount = $this->calculateSupportCount();
        $results['centerRailCount'] = 0;
        
        if ($bestRailSet->checkPassed || 2 === $supportCount) {
            $results['centerRailCount'] = 1;   
        }

        if (2 === $supportCount && $this->parameters['systemLength'] > $this->parameters['stockRail']) {
            $results['intermediateRailCount'] = 1;
        } elseif (2 === $supportCount && $this->parameters['systemLength'] <= $this->parameters['stockRail']) {
            $results['intermediateRailCount'] = 0;
        } elseif ($bestRailSet->checkPassed) {
            $results['intermediateRailCount'] = $bestRailSet->intermediateRailCount;
        }
     
        if (2 === $supportCount) {
            $results['endRailCount'] = 0;
        } elseif ($bestRailSet->checkPassed) {
            $results['endRailCount'] = $bestRailSet->endRailCount;
        } else {
            $results['endRailCount'] = 0;
        }
        
        $results['railLength'] = (float) $this->parameters['stockRail'];
        
        $oneSpanRails = $this->calculateGet1SpanRails();
        
        if ($this->parameters['systemLength'] <= $this->parameters['stockRail']) {
            $results['centerRailLength'] = $this->parameters['systemLength'];
        } elseif (2 === $supportCount && $this->parameters['systemLength'] > $this->parameters['stockRail']) {
            $results['centerRailLength'] = $oneSpanRails['rail1'];
        } elseif (2 === $supportCount && $this->parameters['systemLength'] <= $this->parameters['stockRail']) {
            $results['centerRailLength'] = $this->parameters['systemLength'];
        } elseif ($bestRailSet->checkPassed) {
            $results['centerRailLength'] = $bestRailSet->centerRailLength;
        }
        
        $roundFactor = $this->parameters['tolerance'] >= 100 ? -2 : -1;
        $results['centerRailLength'] = round($results['centerRailLength'], $roundFactor);
                
        if ($this->parameters['systemLength'] <= $this->parameters['stockRail']) {
            $results['intermediateRailLength'] = 0;
            $results['intermediateRailCount'] = 0;
        } elseif (0 === $results['intermediateRailCount']) {
            $results['intermediateRailLength'] = 0;
        } elseif (2 === $supportCount && $this->parameters['systemLength'] > $this->parameters['stockRail']) {
            $results['intermediateRailLength'] = $oneSpanRails['rail1'];
        } elseif (2 === $supportCount && $this->parameters['systemLength'] <= $this->parameters['stockRail']) {
            $results['intermediateRailLength'] = 0;
            $results['intermediateRailCount'] = 0;
        } elseif ($bestRailSet->checkPassed) {
            $results['intermediateRailLength'] = $bestRailSet->intermediateRailLength;
        } else {
            $results['intermediateRailLength'] = 0;
            $results['intermediateRailCount'] = 0;
        }
        
        $results['intermediateRailLength'] = round($results['intermediateRailLength'], $roundFactor);

        if ($this->parameters['systemLength'] <= $this->parameters['stockRail']) {
            $results['endRailLength'] = 0;
            $results['endRailCount'] = 0;
        } elseif (2 === $supportCount) {
            $results['endRailLength'] = 0;
            $results['endRailCount'] = 0;
        } elseif ($bestRailSet->checkPassed) {
            $results['endRailLength'] = $bestRailSet->endRailLength;
        } else {
            $results['endRailLength'] = 0;
            $results['endRailCount'] = 0;
        }
        
        $results['endRailLength'] = round($results['endRailLength'], $roundFactor);

        $totalRailCount = array();
        if ('landscape' === $this->parameters['orientation']) {
            $totalRailCount['center'] = $results['centerRailCount'] * ($this->parameters['moduleRows'] + 1);
            $totalRailCount['intermediate'] = $results['intermediateRailCount'] * ($this->parameters['moduleRows'] + 1);
            $totalRailCount['end'] = $results['endRailCount'] * ($this->parameters['moduleRows'] + 1);
        } else {
            $totalRailCount['center'] = $results['centerRailCount'] * ($this->parameters['moduleRows'] * 2);
            $totalRailCount['intermediate'] = $results['intermediateRailCount'] * ($this->parameters['moduleRows'] * 2);
            $totalRailCount['end'] = $results['endRailCount'] * ($this->parameters['moduleRows'] * 2);
        }

        $results['railsPerRow'] = $railsPerRow = $results['centerRailCount'] + $results['intermediateRailCount'] + $results['endRailCount'];
        $spliceCount = ($railsPerRow - 1) * ($this->parameters['moduleRows'] * 2);

        $stockRailCut = new StockRailCut(
            array(
                1 => $this->parameters['maxRail'],
                2 => $this->parameters['maxRail'],
                3 => $this->parameters['minRail'],
                4 => $this->parameters['minRail'],
                5 => $this->parameters['minRail'],
            ),
            array(
                'center' => (int) round($results['centerRailLength'], 0),
                'intermediate' => (int) round($results['intermediateRailLength'], 0),
                'end' => (int) round($results['endRailLength'], 0),
            ),
            $totalRailCount
        );
        
        $optimalRailCut1 = new OptimalRailCut1($stockRailCut);
        $optimalRailCut2 = new OptimalRailCut2($stockRailCut);
        $optimalRailCut3 = new OptimalRailCut3($stockRailCut);        
        $optimalRailCut4 = new OptimalRailCut4($stockRailCut);        
        $optimalRailCut5 = new OptimalRailCut5($stockRailCut);    
        
        $railResults = array();
        $railResults['stock'] = $stockRailCut->getMostEfficientRails();
        $railResults[1] = $optimalRailCut1->getMostEfficientRails();
        $railResults[2] = $optimalRailCut2->getMostEfficientRails();
        $railResults[3] = $optimalRailCut3->getMostEfficientRails();
        $railResults[4] = $optimalRailCut4->getMostEfficientRails();
        $railResults[5] = $optimalRailCut5->getMostEfficientRails();
        
        $fewestRails = array();
        $fewestRails['stock'] = $railResults['stock']['totalShippingLength'];
        $fewestRails[1] = $railResults[1]['totalShippingLength'];
        $fewestRails[2] = $railResults[2]['totalShippingLength'];
        $fewestRails[3] = $railResults[3]['totalShippingLength'];
        $fewestRails[4] = $railResults[4]['totalShippingLength'];
        $fewestRails[5] = $railResults[5]['totalShippingLength'];
        
        $mostEfficientLength = min($fewestRails);
        $mostEfficientCut = array_search($mostEfficientLength, $fewestRails);
        
        if (
            max($results['centerRailLength'], $results['intermediateRailLength'], $results['endRailLength']) > $this->parameters['stockRail'] ||
            $results['centerRailLength'] == 0 ||
            ($this->parameters['supportCount'] <= 2 && $oneSpanRails['rail1'] > $this->parameters['stockRail'])
        ) {
            $confirmation = 'Custom rail is required';
        } else {
            $railLengthPerRow = $results['centerRailCount'] * $results['centerRailLength'] + $results['intermediateRailCount'] * $results['intermediateRailLength'] + 
                $results['endRailCount'] * $results['endRailLength'];
            $difference = $railLengthPerRow - $this->parameters['systemLength'];
            $toleranceOK = abs($difference) < $tolerance;
            if ($toleranceOK) {
                $confirmation = "Confirmed ({$difference}mm)";
            } else {
                $overage = abs($difference) - $tolerance;
                $confirmation = "Out of Spec ({$overage}mm)";
            }
        }
                
        $results['railsShipping'] = $railResults[$mostEfficientCut]['railsShipping'];
        $results['spliceCount'] = $spliceCount;
        $results['confirmation'] = $confirmation;
        $results['stockRailQuantity'] = $railResults[$mostEfficientCut]['stockRailQuantity'];
        
        // Instructions
        $result = $railResults[$mostEfficientCut];
        $wastePercentage = $result['wastePercentage'] * 100;
        $wasteInstructions = "with {$wastePercentage}% [{$result['wasteLength']}mm] of {$result['totalShippingLength']}mm wasted";
        $results['instructions'] = $railResults[$mostEfficientCut]['instructions'];
       // $results['instructions'][5] = $wasteInstructions;
        
        return $results;
    }
    
    public function calculateGet1SpanRails()
    {
        $w = 1000;
        $mmPerFt = 304.8;
        $a = $this->parameters['cantilever'];
        $aInFt = $a / $mmPerFt;
        $b = $this->parameters['span'];
        $bInFt = $b / $mmPerFt;
        $c = $a;
        $cInFt = $c / $mmPerFt;
        $l = $a + $b + $c;
        $lInFt = $l / $mmPerFt;
        
        $R1 = ($w * $lInFt * ($lInFt - 2 * $cInFt)) / (2 * $bInFt);
        
        $mxLookup = array();
        for ($i = 0; $i <= 50; $i++) {
            $mxLookup[$i] = array();
            $X = ($bInFt / 50) * $i;
            $mxLookup[$i]['X'] = $X;
            $mxLookup[$i]['Mx'] = $R1 * $X - ($w * pow($aInFt + $X, 2)) / 2;
        }
        
        $mfind = 0;
        $mxLookupTemp = $mxLookup;
        foreach ($mxLookupTemp as &$values) {
            $values['Mx'] = abs($values['Mx'] - $mfind);
        }
        uasort($mxLookupTemp, function($a, $b) {
            if ($a['Mx'] < $b['Mx']) {
                return -1;   
            } elseif ($a['Mx'] == $b['Mx']) {
                return 0;
            } else {
                return 1;
            }
        });
        
        $smallest = reset($mxLookupTemp);
        $find = $smallest['Mx'];
        
        $indexInFt = $smallest['X'];
        $indexInMm = $indexInFt * 304.8;
        
        $spliceAt = $indexInMm + $a;
        
        $result = array(
            'rail1' => $spliceAt,
            'rail2' => $this->parameters['systemLength'] - $spliceAt,
        );
        
        return $result;
    }
    
    public function calculateSupportCount()
    {
        return max(ceil($this->parameters['systemLength'] / $this->parameters['span']), 2.0);
    }
    
    public function findBestRailSet()
    {
        $railChecks = array();
        
        // Check #1
        $supportCount = $this->calculateSupportCount();
        $potentialRailCalculator = new PotentialCenterRailCalculator($this->parameters['span'], $supportCount, $this->parameters['splicePercentage']);
        $idealRail = $potentialRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength']);
        $idealRail = ($this->parameters['systemLength'] <= $this->parameters['stockRail']) ? $this->parameters['systemLength'] : $idealRail;
        $oppositeRailCheck = new EndRailCheckAgainstCantilever(
            $this->parameters['cantilever'], 
            $this->parameters['splicePercentage'], 
            $this->parameters['span'], 
            $this->parameters['stockRail'], 
            $idealRail, 
            $this->parameters['systemLength']
        );
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($this->parameters['span'], $supportCount, $this->parameters['splicePercentage']);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength']);
        $railCheck1 = new RailCheck($idealRail, $this->parameters['systemLength'], $oppositeRailCheck, $idealRemainingRailLength);
        $railChecks[1] = $railCheck1->run();
        
        // Check #2
        $nextIdealRail = $potentialRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength'], 1, $idealRail);
        $oppositeRailCheck = new EndRailCheckAgainstCantilever(
            $this->parameters['cantilever'], 
            $this->parameters['splicePercentage'], 
            $this->parameters['span'], 
            $this->parameters['stockRail'], 
            $nextIdealRail, 
            $this->parameters['systemLength']
        );
        $railCheck2 = new RailCheck($nextIdealRail, $this->parameters['systemLength'], $oppositeRailCheck, $idealRemainingRailLength);
        $railChecks[2] = $railCheck2->run();

        // Check #3
        $secondToLastIdealRail = $potentialRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength'], 2, $nextIdealRail);    
        $oppositeRailCheck = new EndRailCheckAgainstCantilever(
            $this->parameters['cantilever'], 
            $this->parameters['splicePercentage'], 
            $this->parameters['span'], 
            $this->parameters['stockRail'], 
            $secondToLastIdealRail, 
            $this->parameters['systemLength']
        );
        $railCheck3 = new RailCheck($secondToLastIdealRail, $this->parameters['systemLength'], $oppositeRailCheck, $idealRemainingRailLength);
        $railChecks[3] = $railCheck3->run();
        
        // Check #4
        $potentialRailCalculator = new PotentialEndRailCalculator($this->parameters['span'], $supportCount, $this->parameters['splicePercentage'], $this->parameters['cantilever']);
        $idealRail = $potentialRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength']);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail(
            $this->parameters['cantilever'], 
            $this->parameters['splicePercentage'], 
            $this->parameters['span'], 
            $this->parameters['stockRail'], 
            $idealRail, 
            $this->parameters['systemLength']
        );
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($this->parameters['span'], $supportCount, $this->parameters['splicePercentage']);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);
        $railCheck4 = new RailCheck($idealRail, $this->parameters['systemLength'], $oppositeRailCheck, $idealRemainingRailLength, 'end');
        $railChecks[4] = $railCheck4->run();
        
        // Check #5
        $idealRail = $potentialRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength'], 1);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail(
            $this->parameters['cantilever'], 
            $this->parameters['splicePercentage'], 
            $this->parameters['span'], 
            $this->parameters['stockRail'], 
            $idealRail, 
            $this->parameters['systemLength']
        );
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($this->parameters['span'], $supportCount, $this->parameters['splicePercentage']);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);

        $railCheck5 = new RailCheck($idealRail, $this->parameters['systemLength'], $oppositeRailCheck, $idealRemainingRailLength, 'end');
        $railChecks[5] = $railCheck5->run();
        
        // Check #6
        $idealRail = $potentialRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength'], -1);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail(
            $this->parameters['cantilever'], 
            $this->parameters['splicePercentage'], 
            $this->parameters['span'], 
            $this->parameters['stockRail'], 
            $idealRail, 
            $this->parameters['systemLength']
        );
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($this->parameters['span'], $supportCount, $this->parameters['splicePercentage']);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($this->parameters['span'], $supportCount, $this->parameters['splicePercentage']);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength'], -1);
        
        $railCheck6 = new RailCheck($idealRail, $this->parameters['systemLength'], $oppositeRailCheck, $idealRemainingRailLength, 'end');
        $railChecks[6] = $railCheck6->run();

        // Check #7; this appears to be the same as #4
        $railChecks[7] = $railCheck4->run();
        
        // Check #8
        $idealRail = $potentialRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength']);
        $oppositeRailCheck = new CenterRailCheckAgainstStockRail(
            $this->parameters['cantilever'], 
            $this->parameters['splicePercentage'], 
            $this->parameters['span'], 
            $this->parameters['stockRail'], 
            $idealRail, 
            $this->parameters['systemLength']
        );
        $potentialCenterRailCalculator = new PotentialCenterRailCalculator($this->parameters['span'], $supportCount, $this->parameters['splicePercentage']);
        $oppositeRailCheck->setCenterRailCalculator($potentialCenterRailCalculator);
        $idealRemainingRailCalculator = new PotentialIntermediateRailCalculator($this->parameters['span'], $supportCount, $this->parameters['splicePercentage']);
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength'], -2);
        
        $railCheck8 = new RailCheck($idealRail, $this->parameters['systemLength'], $oppositeRailCheck, $idealRemainingRailLength, 'end');
        $railChecks[8] = $railCheck8->run();
        
        // Check #9
        $idealRemainingRailLength = $idealRemainingRailCalculator->getIdealRail($this->parameters['stockRail'], $this->parameters['systemLength'], -3);
        
        $railCheck9 = new RailCheck($idealRail, $this->parameters['systemLength'], $oppositeRailCheck, $idealRemainingRailLength, 'end');
        $railChecks[9] = $railCheck9->run();
        
        // Check #10
        $railCheck10 = new FinalRailCheck($this->parameters['systemLength'], $this->parameters['stockRail'], $potentialRailCalculator);
        $railChecks[10] = $railCheck10->run();
        
        // Comparisons -- Calculations!N73:N78
        if ($railChecks[10]->checkPassed) {
            $bestRailSet = $railChecks[10];
        } else {
            $railSetChoices = array_filter($railChecks, function($railCheck) {
               return $railCheck->checkPassed; 
            });

            $minIntermediateRailCount = null;
            foreach ($railSetChoices as $railSetChoice) {
                if (null === $minIntermediateRailCount) {
                    $minIntermediateRailCount = $railSetChoice->intermediateRailCount;
                } elseif ($railSetChoice->intermediateRailCount < $minIntermediateRailCount) {
                    $minIntermediateRailCount = $railSetChoice->intermediateRailCount;
                }
            }

            // Filter to those choice that match the minimum and keep the key order.
            $railSetChoices = array_filter($railSetChoices, function($railSetChoice) use ($minIntermediateRailCount) {
               return $railSetChoice->intermediateRailCount === $minIntermediateRailCount;
            });

            $bestRailSet = reset($railSetChoices);
        }

        return $bestRailSet;
    }
}
