<?php 

namespace Schletter\GroundMount;

abstract class RailCut
{
    protected $stockRails;
    protected $requiredRails;
    protected $requiredQuantities;
    
    public function __construct($stockRails, $requiredRails, $requiredQuantities)
    {
        $this->stockRails = $stockRails;
        $this->requiredRails = $requiredRails;
        $this->requiredQuantities = $requiredQuantities;
    }
    
    public function getStockRails()
    {
        return $this->stockRails;
    }
    
    public function getRequiredRails()
    {
        return $this->requiredRails;
    }
    
    public function getrequiredQuantities()
    {
        return $this->requiredQuantities;
    }
    
    abstract public function getMostEfficientRails();
}
