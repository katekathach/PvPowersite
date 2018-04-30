<?php

namespace Schletter\GroundMount;

use Schletter\GroundMount\Database;

class FormData
{
    protected $db;
    
    public function __construct()
    {
        $dbInstance = Database::getInstance();
        $this->db = $dbInstance->getConnection();
    }
    
    public function getWindSpeeds()
    {
        $result = mysql_query(
            'select codeVersion, wind from load_tables group by codeVersion, wind',
            $this->db
        );
        
        $windSpeeds = array();
        while ($row = mysql_fetch_assoc($result)) {
            if (!array_key_exists($row['wind'], $windSpeeds)) {
                $windSpeeds[$row['wind']] = array();
            }
            $windSpeeds[$row['wind']][] = 'code-version-'.$row['codeVersion'];
        }
        ksort($windSpeeds);

        return $windSpeeds;
    }
    
    public function getSnowLoads()
    {
        $result = mysql_query(
            'select distinct snow from load_tables',
            $this->db
        );
        
        $snowLoads = array();
        while ($row = mysql_fetch_assoc($result)) {
            $snowLoads[] = $row['snow'];
        }
        sort($snowLoads);

        return $snowLoads;
    }

    public function getTilts()
    {
        $result = mysql_query(
            'select distinct tilt from load_tables',
            $this->db
        );
        
        $tilts = array();
        while ($row = mysql_fetch_assoc($result)) {
            $tilts[] = $row['tilt'];
        }
        sort($tilts);

        return $tilts;
    }
}
