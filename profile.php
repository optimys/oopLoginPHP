<?php
require_once('core/init.php');

if(Input::get('user')){
    $user = new User();
    if($user->exists()){
        $data = $user->data();
    }else{
        Redirect::to(404);
    }
}else{
    Redirect::to('index');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User page</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body style="background-color: #eeeeee;">
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <h2>User page</h2>
            <div class="col-md-3">
                <ul class="list-group">
                    <li class="list-group-item"><a href="index.php">home</a></li>
                    <li class="list-group-item"><a href="update.php">change name</a></li>
                    <li class="list-group-item"><a href="changepassword.php">change password</a></li>
                </ul>
                </div>
            <div class="col-md-9">
                <a class="media-left" href="#">
                    <img src="no-person.jpg" class="img-rounded" alt="User photo">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">User info</h4>
                    <dl>
                        <dt>Name</dt>
                        <dd><?=$data->username?></dd>
                        <dt>Full name</dt>
                        <dd><?=$data->name?></dd>
                    </dl>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="bower_components/jquery/src/jquery.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
</body>
</html>