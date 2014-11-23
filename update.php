<?php
require_once('core/init.php');

$user = new User();
if ($user->isLoggedIn()) {
    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                    'min' => 6,
                    'max' => 20
                )
            ));
            if ($validation->passed()) {
                try {
                    $user->update(array(
                        'name' => Input::get('name')
                    ));
                    Session::flash('success', 'Your name have been changed successfully !');
                    Redirect::to('index');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $validation->errors();
            }
        }
    }
} else {
    Session::flash('success', 'You have first logged in to change your name');
    Redirect::to('index');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update user name</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="jumbotron">
    <div class="container">
        <div class="row ">
            <h3>Update page</h3>

            <div class="col-md-3">
                <ul class="list-group">
                    <li class="list-group-item"><a href="index.php">home</a></li>
                    <li class="list-group-item"><a href="update.php">change name</a></li>
                    <li class="list-group-item"><a href="changepassword.php">change password</a></li>
                    <li class="list-group-item"><a href="profile.php">my profile</a></li>
                    <li class="list-group-item"><a href="login.php">login</a></li>
                    <li class="list-group-item"><a href="register.php">register</a></li>
                </ul>
            </div>
            <form class="col-md-6" action="" method="post">
                <label class="col-md-4" for="name">New user name</label>

                <div class="col-md-8">
                    <input type="text" name="name" id="name" value="<?= escape($user->data()->name) ?>"/>
                    <button class="btn btn-success pull-right" type="submit">Update name</button>
                </div>
                <input type="text" name="token" id="token" hidden="hidden" value="<?= Token::generate() ?>"/>
            </form>
        </div>
    </div>
    <script src="bower_components/jquery/src/jquery.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
</div>
</body>
</html>