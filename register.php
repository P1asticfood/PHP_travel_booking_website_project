<?php
include_once 'database.php';
include_once 'config.php';

$errors = [
    'name' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => '',
    'role' => '',
    'gender' => ''

];

$old = [
    'name' => '',
    'email' => '',
    'gender' => ''

];

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $errors[$key] = "field required";
        } else {
            $old[$key] = htmlspecialchars($value);
        }
    }
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "invalid email format";
    }

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $errors['email'] = "Email already exists";
    }

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password !== $confirm_password) {
        $errors['password'] = "password does not match";
    }
    $password = md5($password);
    $role = $_POST['role'];
    $gender = $_POST['gender'];


    if (!array_filter($errors)) {
        $sql = "INSERT INTO users(name,email,password,role,gender) VALUES ('$name', '$email', '$password','$role', '$gender')";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            $_SESSION['success'] = "user added sucessfully";
            redirect("login.php");
        }
    }

}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .register-form {
            max-width: 600px;
            margin: 4rem auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .form-label span {
            font-size: 0.875rem;
        }

        .btn-register {
            background-color: #0DCAF0;
            color: white;
            font-weight: 500;
        }

        .btn-register:hover {
            background-color: #16a6cb;
        }
    </style>
</head>

<body>

    <div class="register-form">
        <h3 class="text-center mb-4">Register New User</h3>
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name:
                    <span class="text-danger"><?= $errors['name']; ?></span>
                </label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $old['name'] ?>"
                    placeholder="Full Name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:
                    <span class="text-danger"><?= $errors['email']; ?></span>
                </label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $old['email'] ?>"
                    placeholder="you@example.com" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password:
                        <span class="text-danger"><?= $errors['password']; ?></span>
                    </label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password:
                        <span class="text-danger"><?= $errors['confirm_password']; ?></span>
                    </label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="gender" class="form-label">Gender:
                    <span class="text-danger"><?= $errors['gender']; ?></span>
                </label>
                <select class="form-select" name="gender" id="gender" required>
                    <option value="">--- Select Gender ---</option>
                    <option value="male" <?= $old['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= $old['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                    <option value="other" <?= $old['gender'] == 'other' ? 'selected' : '' ?>>other</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="role" class="form-label">Role:
                    <span class="text-danger"><?= $errors['role']; ?></span>
                </label>
                <select class="form-select" name="role" id="role" required>
                    <option value="">---Select role--- </option>
                    <option value="customer" <?= $old['role'] == 'customer' ? 'selected' : '' ?>>Customer</option>
                    <option value="admin" <?= $old['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-register w-100">Create Account</button>
        </form>
    </div>

</body>

</html>