<?php

namespace Schletter\GroundMount;

use mysqli;
use Exception;

/**
 * We really should use mysqli or PDO, but the Schletter server is old and
 * we're not sure of its capabilities.
 */
class Database
{
    private static $instance;
    protected $connection;
    
    protected function __construct()
    {
        require_once './protected/properties.php';

        $this->connection = mysql_connect(DB_HOST, DB_USER, DB_PASS);
        mysql_select_db(DB_NAME);
        
        if (mysql_error($this->connection)) {
            throw new Exception('Database connection error: '.$this->connection->connect_error);
        }
    }
    
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }
    
    public function getConnection()
    {
        return $this->connection;
    }
}
