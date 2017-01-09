<?php

class Redirect {
    public static function to($location = null) {
        if(!$location) {
            return;   
        }
        
        if(is_numeric($location)) {
            switch($location) {
                case 404:
                    header('HTTP/1.0 404 NOT FOUND');
                    include 'app/404.php';
                    exit();
                break;
            }
        }
            
        header('Location:' . $location);
        exit();
    }
    
    
}