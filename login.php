<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

if(isset($_SESSION['user'])){
    redirect('admin');
}

$errors=[
    'email' => '',
    'password' => ''
];

$old=[
    'email' => '',
    'password' => ''

];

if(!empty($_POST)){
    foreach($_POST as $key=>$value){
        if(empty($value)){
            $errors[$key] = "This field is required";
        }
        else{
            $old[$key] = htmlspecialchars($value);
        }
    }
    $email=$_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Invalid email format";
    }
    $password=md5($_POST['password']);

    if(!array_filter($errors)){
        $sql="SELECT * FROM users WHERE email='$email' AND password='$password' ";
        $res=mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) > 0){

            $_SESSION['user']=mysqli_fetch_assoc($res);
            redirect('admin');

        }else{
            $_SESSION['error'] = "Invalid email or password";
        }
    }

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Login</h1>
                <?=messages(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post">
                    <div class="form-group mb-2">
                        <label for="email">Email:
                            <span class='text-danger'><?=$errors['email']?></span>
                        </label>
                        <input type="text" name="email" value="<?=$old['email']?>" id="email" class="form-control" required>
                    </div>
                   
                            <div class="form-group mb-2">
                                <label for="password">Password:
                            <span class='text-danger'><?=$errors['password']?></span>
                                </label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                    
                    <button class="btn btn-success w-100">Add User</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>