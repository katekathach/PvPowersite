<?php

namespace Schletter\GroundMount;

use Schletter\GroundMount\Database;
use Schletter\GroundMount\Exception\NoLoadTableRowFoundException;

class LoadTableRow
{
    protected $parameters = array();
    protected $db;
    
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
        $dbInstance = Database::getInstance();
        $this->db = $dbInstance->getConnection();
    }
    
    /**
     * Get first row that matches our load table specs.
     */
public function getData()
    {
        $result = mysql_query(
            sprintf('select * from load_tables where cellType = %d'.
            ' and tilt = %d and snow = %d and wind = %d and codeVersion = %d'.
            ' and seismic = %d',
            (int) $this->parameters['cellType'], (int) $this->parameters['tilt'],
            (int) $this->parameters['snow'], (int) $this->parameters['wind'],
            (int) $this->parameters['codeVersion'], (int) $this->parameters['seismic']),
            $this->db
        );
        
        if ($row = mysql_fetch_assoc($result)) {
            $connectionForces = array('FCT', 'FCC', 'FCS', 'RCT', 'RCC', 'RCS');
            foreach ($connectionForces as $force) {
                $row[$force] = round($row[$force] / 1000.0, 2);
            }
            $row['rebarCount'] = (int) floor($row['ballastWidth'] / 12);
        
            return $row;
        } else {
            throw new NoLoadTableRowFoundException();
        }
    }
}
