<?php
require_once('core/init.php');

$user = DB::getInstance()->get('users', array('username', '=', 'Alex473'));

if(!$user->count()){
    echo "Error!";
}else{
    echo "OK";
}