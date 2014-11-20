<?php
require_once('core/init.php');

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();                     //Создаем объект проверки
        $validation = $validate->check($_POST, array(    //Вызываем метод проверки у этого объекта. Результат сразу пишем в переменную! $validation
            'username' => array('required' => true),     // Как результат, нам вернется целый ОБЪЕКТ!
            'password' => array('required' => true)      // У этого объекта будет метод, который показывает что было
        ));                                             //записано в его свойство о результате проверки
        if ($validation->passed()) {                      //Этот метод как раз и возвращает это свойство
            $user = new User();                          //Создаемновый объект user и сразу
            $login = $user->login(Input::get('username'), Input::get('password')); // Возвращаем в переменную результат проверки
            if ($login) {
                Session::flash('loggedin', 'You logged in successfully');
                Redirect::to('index');
            } else {
                echo "There was a problem with login";
            }
        } else {
            $validation->errors();                      //Выводим список ошибок, и снова благодяря методу
        }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="jumbotron">
    <div class="container">
        <h3>Login Page</h3>
        <a href="register.php">register</a><br>
        <a href="index.php">home</a>

        <div class="row">
            <form action="" method="post" class="form-horizontal col-md-5 col-lg-offset-3">
                <div class="form-group">
                    <lable class="col-md-4" for="username">Your login</lable>
                    <div class="col-md-8">
                        <input class="form-control" name="username" id="username" type="text"/></div>
                </div>
                <div class="form-group">
                    <lable class="col-md-4" for="password">Your password</lable>
                    <div class="col-md-8">
                        <input class="form-control" name="password" id="password" type="password" autocomplete="off"/>
                    </div>
                </div>
                <input class="token" name="token" type="text" hidden="hidden" value="<?= Token::generate() ?>"/>
                <button class="btn btn-success pull-right" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
<script src="bower_components/jquery/src/jquery.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
</body>
</html>