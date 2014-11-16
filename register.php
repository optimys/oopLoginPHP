<?php
require_once("core/init.php");
if (Input::exist()) {
    $validate = new Validate();
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

    if( $validation->passed() ){
        echo "<div class='alert alert-success' role='alert'>Passed</div>";
    }else{
        $validation->errors();
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
<body>

<div class="jumbotron">
    <div class="container">
        <h3>Register new user</h3>
        <form action="" method="post" class=" form-horizontal col-md-5 col-md-offset-3">
            <div class="form-group">
                <lable class="col-md-4" for="username">Your Login name</lable>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="username" id="username" autocomplete="off" value="<?=escape(Input::get('username'));?>"/>
                </div>
            </div>
            <div class="form-group">
                <lable class="col-md-4" for="password">Password</lable>
                <div class="col-md-8">
                    <input class="form-control" type="password" name="password" id="password"/>
                </div>
                <br>
            </div>
            <div class="form-group">
                <lable class="col-md-4" for="password_again">Password again</lable>
                <div class="col-md-8">
                    <input class="form-control" type="password" name="password_again" id="password_again"/>
                </div>
            </div>
            <div class="form-group">
                <lable class="col-md-4" for="name">Your full name</lable>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="name" id="name" autocomplete="off" value="<?=escape(Input::get('name'));?>"/>
                </div>
            </div>
            <button class="btn btn-success pull-right" type="submit">Submit</button>
        </form>
    </div>
</div>
</body>
<script src="bower_components/jquery/src/jquery.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
</html>

