<?php
require_once 'app/start.php';

if (Session::exists('ok')) {
    echo Session::flash('ok');  
}