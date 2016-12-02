<?php 

class Config {
    public static function get($path = null) {
        if (!$path) {
            die('brak sciezki');
        }
        $config = $GLOBALS['config'];
        $path = explode('/',$path);
        
        foreach ($path as $key) {
            if (!isset($config[$key])) {
                die('nie znaleziono klucza');                  
            }
            $config = $config[$key];
        }
       return $config;
    }
}

//echo config::get('mysql/host');