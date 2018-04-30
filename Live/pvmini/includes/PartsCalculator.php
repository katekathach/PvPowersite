<?php

namespace Schletter\GroundMount;

use Schletter\GroundMount\Database;

class PartsCalculator {
    
    /**
     * In this array, we need splice count, support count, module count, span count, braces, thickness, rail from load table lookup
     */
    protected $calculations = array();
    
    protected $db;
    
    protected $parts = array(
        
    );
    
    public function __construct($calculations)
    {
        $this->calculations = $calculations;
        $dbInstance = Database::getInstance();
        $this->db = $dbInstance->getConnection();
        
        $systemLengthInFt = $this->calculations['systemLength'] / 304.8;
        $this->calculations['supportCount'] = max(ceil($systemLengthInFt / $this->calculations['maxSpan']), 2);
        $this->calculations['spanCount'] = $this->calculations['supportCount'] - 1;
    }
    
    public function getParts()
    {
        $parts = array(
            'rails' => $this->getRails(),
            'splices' => $this->getSplices(),
            'supports' => $this->getSupports(),
            'endClamps' => $this->getEndClamps(),
            'midClamps' => $this->getMidClamps(),
            'braces' => $this->getBraces(),
            'safetyHooks' => $this->getSafetyHooks(),
        );
                
        return $parts;
    }
    
    protected function getRails()
    {
        $rails = array();
        foreach ($this->calculations['stockRailQuantity'] as $length => $quantity) {
            if (0 !== $quantity) {
                $result = mysql_query(
                    sprintf(
                        'select * from parts where part_type = "rail" and rail_type = "%s" and rail_length = %d',
                        mysql_real_escape_string($this->calculations['purlinType']), $length
                    ),  
                    $this->db
                );
                $row = mysql_fetch_assoc($result); 
                $rails[] = array(
                    'partNumber' => $row['part_number'],
                    'name' => $row['name'],
                    'quantity' => $quantity * $this->calculations['numberRacks'],
                );
            }
        }

        return $rails;
    }
    
    protected function getSplices() 
    {
        $splices = array();
        $result = mysql_query(
            sprintf(
                'select * from parts where part_type = "splice" and rail_type = "%s"',
                mysql_real_escape_string($this->calculations['purlinType'])
            ),  
            $this->db
        );
        $row = mysql_fetch_assoc($result); 
        $splices[] = array(
            'partNumber' => $row['part_number'],
            'name' => $row['name'],
            'quantity' => $this->calculations['spliceCount'] * $this->calculations['numberRacks'],
        );
        
        return $splices;
    }
    
    protected function getSupports() 
    {
        $supports = array();
        $result = mysql_query(
            sprintf(
                'select * from parts where part_type = "support" and tilt = %d',
                $this->calculations['tilt']
            ),  
            $this->db
        );
        $row = mysql_fetch_assoc($result); 
        $supports[] = array(
            'partNumber' => $row['part_number'],
            'name' => $row['name'],
            'quantity' => $this->calculations['supportCount'] * $this->calculations['numberRacks'],
        );
        
        return $supports;
    }
    
    protected function getEndClamps() 
    {
        $endClamps = array();
        $result = mysql_query(
            sprintf(
                'select * from parts where part_type = "endClamp" and min_thickness >= %f and max_thickness <= %f',
                $this->calculations['moduleThickness'], $this->calculations['moduleThickness']
            ),  
            $this->db
        );
        $row = mysql_fetch_assoc($result); 
        $endClamps[] = array(
            'partNumber' => $row['part_number'],
            'name' => $row['name'],
            'quantity' => 4 * $this->calculations['numberRacks'],
        );
        
        return $endClamps;
    }

    protected function getMidClamps()
    {
        $midClamps = array();
        $result = mysql_query(
            sprintf(
                'select * from parts where part_type = "midClamp" and min_thickness <= %f and max_thickness >= %f',
                $this->calculations['moduleThickness'], $this->calculations['moduleThickness']
            ),  
            $this->db
        );
        $row = mysql_fetch_assoc($result); 
        $midClamps[] = array(
            'partNumber' => $row['part_number'],
            'name' => $row['name'],
            'quantity' => 2 * ($this->calculations['moduleRows'] * $this->calculations['moduleColumns'] - 1) * $this->calculations['numberRacks'],
        );
        
        return $midClamps;        
    }
    
    protected function getBraces()
    {
        $braces = array();
        $result = mysql_query(
            sprintf(
                'select * from parts where part_type = "brace" and cells = %d',
                $this->calculations['cellType']
            ),  
            $this->db
        );
        $row = mysql_fetch_assoc($result); 
        $braces[] = array(
            'partNumber' => $row['part_number'],
            'name' => $row['name'],
            'quantity' => ceil(($this->calculations['supportCount'] - 1) / $this->calculations['brace']) * $this->calculations['numberRacks'],
        );
        
        return $braces;        
    }
    
    protected function getSafetyHooks()
    {
        $safetyHooks = array();
        $result = mysql_query(
            sprintf(
                'select * from parts where part_type = "safetyHook" and min_thickness >= %f and max_thickness <= %f',
                $this->calculations['moduleThickness'], $this->calculations['moduleThickness']
            ),  
            $this->db
        );
        $row = mysql_fetch_assoc($result); 
        if ($row) {
            $safetyHooks[] = array(
                'partNumber' => $row['part_number'],
                'name' => $row['name'],
                'quantity' => ($this->calculations['moduleColumns'] + 1) * $this->calculations['moduleRows'],
            );
        }
        
        return $safetyHooks;
    }
}
