<?php
/**
 * Data validation class.
 */

class Validate{
    private $_passed = false,
        $_errors = array(),
        $_db = null;

    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array()){
        foreach($items as $item => $rules){
            foreach($rules as $rule => $rule_value){
                // echo "{$item} {$rule} must be {$rule_value}<br>";
                $value = $source[$item];
                // echo $value . '<br>';

                if($rule === 'required' && empty($value)){
                    $this->addError("{$item} is required");
                }else if(!empty($value)){
                    switch($rule){
                        case 'min':
                            break;
                        case 'min':
                            break;
                        case 'min':
                            break; 
                        case 'min':
                            break;    
                    }
                }
            }
        }

        if(empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error){
        $this->_errors[] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }
}