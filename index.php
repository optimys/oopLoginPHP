<?php
require_once('core/init.php');

$user = DB::getInstance()->update("users", array(
    "username"=>"AlexKalshnikov",
    "password"=>"tantal",
    "salt"=>"Super"
), 2);
