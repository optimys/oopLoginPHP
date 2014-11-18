<?php
require_once('core/init.php');

if(Session::exists('success')){     //Проверяем есть ли сессия с именем success(которую мы должны били установить если
    echo Session::flash('success'); //регистрация прошла успешно)
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home page</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<h3>Home Page</h3>
<a href="register.php">To register</a>
</body>
<script src="bower_components/jquery/src/jquery.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
</html>