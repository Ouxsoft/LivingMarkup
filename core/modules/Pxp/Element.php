<?php 
/*

Pxp\Element

This is an abstract class inteded to be extended by Pxp element handlers

*/

namespace Pxp;

interface ElementDefaultInterface
{
    const MAX_RESULTS = '240';
    public function view();
//    public function __construct($args);
    public function __toString();
}

abstract class Element implements ElementDefaultInterface
{
	use \DynamicDataType\Request;

    public $include_in_search_index = true;
    public $name = 'unknown';
    public $id = 0;
    public $args = [];
    public $tags = [];

   	// uses path parameters, e.g.
	// assests/id/1000/dimension/10x10/offset/10000,-10000/black-kitten.jpg
	// assests/id/99/decorative.jpg
	public function getPathFromParameters($parameters){
		$path = '';
		foreach($parameters as $parameter => $value){

			if($parameter == 'filename'){
				$path .= $value;
				continue;
			}

			if( is_array($value) ){
				switch ($parameter){
					case 'dimension':
						$glue = 'x';
						break;
					default:
						$glue = ',';
						break;
				}
				$value = implode($glue,$value);
			}

			$path .= $parameter . '/' . $value . '/';
		}

		$path = preg_replace('/^[\w#-]+$/', '', $path);
		$path = str_replace(' ', '-', $path);
		$path = strtolower($path);

		return $path;
	}

    // extending class must define this method
    abstract public function view();

    // load and merge args
    public function loadArgs($id){
        // $this->args = 
        // merege with args passed
    }

    // get any argments set in element passed by Pxp\Document
    public function __construct($args, $element){
        $this->args = $args; //func_get_args();
        $this->element = $element;
        
        // if ID passed load arguments
        if(isset($args['@attributes']['id'])){
            // load args 
            $this->loadArgs($args['@attributes']['id']);            
        }
    }
    /*
    public function __call($a,$b) {
        // this function does not exist
//        return false;
    }
    */
	public function __toString(){
        // view
        if( method_exists($this,'view') ){
            return $this->view();
        }
    }
}


