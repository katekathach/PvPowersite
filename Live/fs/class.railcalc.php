<?php

class MostEfficentRail{
	
	//protected $stockRails;
    protected $requiredRails;
   // protected $requiredQuantities;
    
    public function __construct($requiredRails)
    {
        // $this->stockRails = $stockRails;
         $this->requiredRails = $requiredRails;
		
        // $this->requiredQuantities = $requiredQuantities;		
		//echo "<pre>",print_r($requiredRails),"</pre>";
    }
	
	public function optimal1($requiredRails){
		$stockRail= 1;
		return  array(
            1 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            2 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 1,
            ),
            3 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            4 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            5 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            6 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 1,
            ),
            7 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 2,
                'end-'.$requiredRails['end'] => 1,
            ),
            8 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 2,
            ),
          9 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 2,
            ),
        );
	}
	
	public function optimal2( $requiredRails){
		$stockRail = 2;
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
	
	public function optimal3( $requiredRails){
		$stockRail = 3;		
	return 	array(
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
	
	public function optimal4( $requiredRails){
		$stockRail = 4;
		return array(
		  1 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            2 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 1,
            ),
            3 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            4 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            5 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            6 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 1,
            ),
            7 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 2,
                'end-'.$requiredRails['end'] => 1,
            ),
            8 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 2,
            ), 
             9 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 2,
            ),        
			);
	}
	
	public function optimal5( $requiredRails){
		 $stockRail = 5;    
		return array(
		  1 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            2 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 1,
            ),
            3 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            4 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 1,
            ),
            5 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 0,
            ),
            6 => array(
                'center-'.$requiredRails['center'] => 2,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 1,
            ),
            7 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 2,
                'end-'.$requiredRails['end'] => 1,
            ),
            8 => array(
                'center-'.$requiredRails['center'] => 0,
                'intermediate-'.$requiredRails['intermediate'] => 1,
                'end-'.$requiredRails['end'] => 2,
            ), 
            9 => array(
                'center-'.$requiredRails['center'] => 1,
                'intermediate-'.$requiredRails['intermediate'] => 0,
                'end-'.$requiredRails['end'] => 2,
            ),        
			);
	}

	    
  
}

?>
