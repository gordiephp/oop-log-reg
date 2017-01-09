<?php

class User {
    private $_db,
            $_data,
            $_sessionName,
            $_loggedIn;
    
    public function __construct($user = null) {
        $this->_db = DB::getInstance();   
        
        $this->_sessionName = Config::get('session/session_name');
        
        if(!$user) {
            if(Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                
                if($this->find($user)) {
                    $this->_loggedIn = true;
                } else {
                       
                }
            }
        
        } else {
            $this->find($user);   
        }
    }
    
    public function create($fields = []) {
        if(!$this->_db->insert('users', $fields)) {
           throw new Exception('problem z utworzeniem'); 
        }
    }
    
    public function find($user = null) {
        if($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';   
            $data = $this->_db->select('users', [$field, '=', $user]);
            
            if($data->mycount()) {
                $this->_data = $data->row();
                return true;
            }
        }
        return false;
    }
    public function login($username= null, $password = null) {
        $user = $this->find($username);
        
        if($user) {
            if($this->data()->password === Hash::make($password, $this->data()->salt)) {
                Session::put($this->_sessionName, $this->data()->id);   
                return true;
            }
        }   
                
    return false;
    }
    
    public function data() {
        return $this->_data;   
    }
    
    public function loggedIn() {
        return $this->_loggedIn;   
    }
    
    public function logout() {
        Session::delete($this->_sessionName);   
        return;
    }
}