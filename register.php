<?php
require_once("core/init.php");

if (Input::exists()) {                       //Был-ли запрос ?
    if (Token::check(Input::get('token'))) { // Совпадают ли значение сгенирированного ключа и значение сессии
        $validate = new Validate();          // Создаем новый объект проверки данных
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'min' => 2,
                'max' => 50
            )
        ));

        if ($validation->passed()) {
            $user = new User();
            $salt = Hash::salt(32);
            try {
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => Input::get('name'),
                    'joined' => date('Y.m.d H:i:s'),
                    'group' => 1
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
            Session::flash('success', 'Your registration now is complete!'); //После успешной проверки устанвливаем сеесиию с именем "success" и "текстом поздравления"
            Redirect::to('index');//Перенаправляем на главную страницу, там будет проверка на существования сессии с именем success
        } else {
            $validation->errors();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body style="background-color: #eeeeee;">

<div class="jumbotron">
    <div class="container">
        <div class="row">
            <h3>Register new user</h3>
            <div class="col-md-3">
            <ul class="list-group">
                <li class="list-group-item"><a href="index.php">home</a></li>
                <li class="list-group-item"><a href="login.php">login</a></li>
            </ul>
        </div>
            <form action="" method="post" class=" form-horizontal col-md-6">
                <div class="form-group">
                    <label class="col-md-4" for="username">Your Login name</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="username" id="username" autocomplete="off"
                               value="<?= escape(Input::get('username')); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4" for="password">Password</label>
                    <div class="col-md-8">
                        <input class="form-control" type="password" name="password" id="password"/>
                    </div>
                    <br>
                </div>
                <div class="form-group">
                    <label class="col-md-4" for="password_again">Password again</label>
                    <div class="col-md-8">
                        <input class="form-control" type="password" name="password_again" id="password_again"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4" for="name">Your full name</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="name" id="name" autocomplete="off"
                               value="<?= escape(Input::get('name')); ?>"/>
                    </div>
                </div>
                <input type="hidden" name="token" value="<?= Token::generate(); ?>">
                <button class="btn btn-success pull-right" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
<script src="bower_components/jquery/src/jquery.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
</html>

