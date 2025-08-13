<?php
require('db.php');
session_start();

if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string($con, stripslashes($_POST['username']));
    $password = mysqli_real_escape_string($con, stripslashes($_POST['password']));

    $query = "SELECT * FROM `users` WHERE username='$username' AND password='" . md5($password) . "'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);

    if ($rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Username/password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #f0f4f8, #d9e4ec);
        margin: 0; padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .form-container {
        background: #fff;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        max-width: 400px;
        width: 100%;
        box-sizing: border-box;
        text-align: center;
    }
    h1 {
        margin-bottom: 10px;
        color: #333;
    }
    h4 {
        margin-top: 0;
        color: #666;
        font-weight: normal;
        margin-bottom: 25px;
    }
    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }
    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: #007BFF;
        outline: none;
    }
    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #007BFF;
        border: none;
        color: white;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 15px;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    .error-message {
        background-color: #ffe6e6;
        border: 1px solid #ff4d4d;
        color: #b30000;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    p {
        margin-top: 20px;
        font-size: 14px;
        color: #333;
    }
    a {
        color: #007BFF;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
    .server-time {
        margin-top: 25px;
        font-size: 12px;
        color: #888;
    }
</style>
</head>
<body>

<div class="form-container">
    <h1>Log In To Forum</h1>
    <h4>Please login with username and password</h4>

    <?php if (!empty($error_message)): ?>
        <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form action="" method="post" name="login" novalidate>
        <input type="text" name="username" placeholder="Username" required autocomplete="username" />
        <input type="password" name="password" placeholder="Password" required autocomplete="current-password" />
        <input type="submit" name="submit" value="Login" />
    </form>

    <p>Not registered yet? <a href="registration.php">Register Here</a></p>

    <div class="server-time">
        <?php
        date_default_timezone_set('America/Chicago'); // CDT
        echo "Server time is " . date('d/m/Y H:i:s');
        ?>
    </div>
</div>

</body>
</html>
