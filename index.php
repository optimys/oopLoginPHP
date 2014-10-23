<?php
require_once('core/init.php');

$user = DB::getInstance()->get("users", array("username","=","Alex47"));

if(!$user->count()){
    echo "No user" ;
} else {
    echo $user->first()->username; 
}