<?php 

class DB {
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;
    
    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/database'),Config::get('mysql/login'),Config::get('mysql/pass'));
        }
        catch(PDOexception $e) {
            die('blad polaczenia');
            //die('blad' . $e); 
        }
    }
    
    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB;   
        }
        return self::$_instance;
    }
    
    //$user = DB::getInstance()->query("SELECT * FROM users WHERE username = ? OR username = ?" , ['asd','zxc']);
    //var_dump( $user->error());
    public function query($sql, $params = []) { //pobieramy zapytanie $sql i parametry where
        $this->_error = false;
        $this->_query = $this->_pdo->prepare($sql);
        $x = 1;
        
        if(count($params)) {
            foreach($params as $param) {
               $this->_query->bindValue($x, $param);  
               $x++;
            }
        }
            
        if(!$this->_query->execute()) {
            $this->_error = true;
            return $this;
        }
        
        $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
        $this->_count = $this->_query->rowCount();   
        return $this;
    }
    
    public function error() { 
        return $this->_error;   
    }
    
    //$user = DB::getInstance()->action('SELECT *', 'users', ['username','=','grd']);
    public function action($action, $table, $where = []) {
        if(count($where) !== 3) {
            die('zla liczba parametrow');
        }
        $operators  = ['<','>','=','<=','>='];
                           
        $field = $where[0];
        $operator = $where[1];           
        $value = $where[2];
                           
        if (!in_array($operator, $operators)) {
            die('zly operator');
        }
        $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
        
        if (!$this->query($sql, [$value])->error()) {
            return $this;
        }   
        return false; 
    }
    
    //$user = DB::getInstance()->select('users' , ['username', '=', 'grd']);
    public function select($table , $where) {
        return $this->action('SELECT *', $table, $where);
    }
    
    public function delete($table, $where) {
        return $this->action('DELETE', $table, $where);
    }
    
    //DB::getInstance()->insert('users', ['username' => 'asd','password' => '123']);
    public function insert($table, $fields =[]) {
           if(!count($fields)) {
                return false;
           }
        $keys = array_keys($fields);
        $values = '';
        $x = 1;
        
        foreach($fields as $field) {
            $values .= '?';
            if($x < count($keys)) {
                $values .= ', ';
            }
            $x++;
        }
        $sql = "INSERT INTO {$table}" . " (" . implode(', ',$keys) . ") " . "VALUES ({$values})";
        
        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        
    }
            
    public function mycount() {
        return $this->_count;   
    }
    
    //$user = DB::getInstance()->query('SELECT * FROM users');
    //echo $user->results()[0]->username;
    public function results() {
        return $this->_results;   
    }
    
    //$user = DB::getInstance()->query('SELECT * FROM users');
    //echo $user->row()->username;
    public function row() {
        return $this->results()[0];
    }
}




