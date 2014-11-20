<?php
require_once('core/init.php');

if (Session::exists('success')) {     //Проверяем есть ли сессия с именем success(которую мы должны били установить если
    echo Session::flash('success'); //регистрация прошла успешно)
}
if (Session::exists('loggedin')) {
    echo Session::flash('loggedin');
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
<div class="jumbotron">
    <div class="container">
        <h3>Home Page</h3>
        <a href="register.php">register</a><br>
        <a href="login.php">login</a>

        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <?php
                $user = new User();
                if ($user->isLoggedIn()) {
                    echo '<p class="alert alert-warning">Hello '.$user->data()->username.'</p>';
                    echo '<a href="logout.php">Logout</a>';
                } else {
                    echo '<p class="alert alert-warning">You are not loggeded in</p>';
                    echo '<a href="login.php">Login</a><br><a href="register.php">Register</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
<script src="bower_components/jquery/src/jquery.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
</html>