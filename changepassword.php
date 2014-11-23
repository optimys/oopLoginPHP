<?php
require_once('/core/init.php');

$user = new User();
if ($user->isLoggedIn()) {
    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'password' => array(
                    'required' => true,
                ),
                'new_password' => array(
                    'required' => true,
                    'min' => 6
                ),
                'new_password_again' => array(
                    'required' => true,
                    'matches' => 'new_password'
                ),
            ));

            if($validation->passed()){
                if(Hash::make(Input::get('password'), $user->data()->salt) === $user->data()->password ){
                    $salt = Hash::salt(32);
                    try {
                        $user->update(array(
                            'salt' => $salt,
                            'password' => Hash::make(Input::get('new_password'), $salt)
                        ));
                    }catch (Exception $e){
                        die($e->getMessage());
                    }
                    Session::flash('success', 'Your password had been changed!');
                    $user->logout();
                    Redirect::to('index');
                }else{
                    $validation->addError("Your current password doesn't  matches");
                    $validation->errors();
                }
            }else{
                $validation->errors();
            }
        }
    }
} else {
    Session::flash('success', 'You have to be logged in to change you password');
    Redirect::to('index');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chenge password</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <h3>Change Password</h3>

            <div class="col-md-3">
                <ul class="list-group">
                    <ul class="list-group">
                        <li class="list-group-item"><a href="index.php">home</a></li>
                        <li class="list-group-item"><a href="update.php">change name</a></li>
                        <li class="list-group-item"><a href="changepassword.php">change password</a></li>
                        <li class="list-group-item"><a href="profile.php">my profile</a></li>
                        <li class="list-group-item"><a href="login.php">login</a></li>
                        <li class="list-group-item"><a href="register.php">register</a></li>
                    </ul>
            </div>
            <form class="form-horizontal col-md-6" method="post" action="">

                <div class="form-group">
                    <label class="col-md-4" for="password">Password</label>

                    <div class="col-md-8"><input type="password" name="password" id="password"/></div>
                </div>

                <div class="form-group">
                    <label class="col-md-4" for="new_password">New password</label>

                    <div class="col-md-8"><input type="password" name="new_password" id="new_password"/></div>
                </div>

                <div class="form-group">
                    <label class="col-md-4" for="new_password_again">New password again</label>

                    <div class="col-md-8"><input type="password" name="new_password_again" id="new_password_again"/>
                    </div>
                </div>

                <input type="text" name="token" id="token" hidden="hidden" value="<?= Token::generate() ?>"/>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <input type="submit" class="btn btn-success" value="Change password"/>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
<script src="bower_components/jquery/src/jquery.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
</body>
</html>