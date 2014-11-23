<?php
require_once('core/init.php');
$user = new User();
if (Session::exists('success')) {     //Проверяем есть ли сессия с именем success(которую мы должны били установить если
    echo Session::flash('success'); //регистрация прошла успешно)
}
if (Session::exists('loggedin')) {     //Проверяем есть ли сессия с именем success(которую мы должны били установить если
    echo Session::flash('loggedin'); //регистрация прошла успешно)
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home page</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body style="background-color: #eeeeee;">
<div class="jumbotron">
    <div class="container">
        <div class="row ">
            <h3>Home</h3>
            <div class="col-md-3">
                <ul class="list-group">
                    <li class="list-group-item"><a href="login.php">login</a></li>
                    <li class="list-group-item"><a href="register.php">register</a></li>
                    <li class="list-group-item"><a href="index.php">home</a></li>
                    <?php
                        if($user->isLoggedIn()){
                            $username = $user->data()->username;
                            echo <<<HERE
                    <li class="list-group-item"><a href="update.php">change name</a></li>
                    <li class="list-group-item"><a href="changepassword.php">change password</a></li>
                    <li class="list-group-item"><a href='profile.php?user=$username'>my profile</a></li>
HERE;

                        }
                    ?>
                </ul>
            </div>
            <div class="col-md-6">
                <?php
                if ($user->isLoggedIn()) {
                    echo '<p class="alert alert-warning">Hello '.$user->data()->username.'</p>';
                    if($user->hasPermission('admin')){
                        echo '<p class="alert alert-info">And you are an admin !</p>';
                    }
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