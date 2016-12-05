<?php
//require_once '../app/start.php'; //skasowac

class validate {
    private $_passed = false,
            $_errors = [],
            $_db = null;
    
    public function __construct() {
        $this->_db = DB::getInstance();
    }
       
    public function check($source, $items = []) {
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {
                
                $value = $source[$item]; //input post
                
                if ($rule === 'required' && empty($value)) {
                    $this->adderror("pole {$item} jest wymagane");   
                } else if (!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $this->adderror("{$item} musi miec minimum {$rule_value} znaki"); 
                            }
                        break;
                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->adderror("{$item} moze miec maksymalnie {$rule_value} znaki"); 
                            }
                        break;
                        case 'matches':
                            //$value = input password $source = input password_again
                            if($value != $source[$rule_value]) {
                                $this->adderror("{$rule_value} musi byc takie jak w {$item}");   
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->select($rule_value, [$item, '=' , $value]);
                            if($check->mycount()) {
                                 $this->adderror("{$item} uzytkownik juz istnieje");  
                            }
                        break;
                    
                    } //switch
                } //else if
            } //foreach 2
        } //forech 1
        
        if(empty($this->_errors)) {
            $this->_passed = true;   
        }
    }
    
    private function adderror($error) {
        $this->_errors[] = $error;
    }
    
    public function errors() {
        return $this->_errors;   
    }
    
    public function passed() {
        return $this->_passed;   
    }
}

