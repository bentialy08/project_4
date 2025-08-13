<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Registration</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #f0f4f8, #d9e4ec);
        margin: 0; padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
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
    h1, h3 {
        color: #333;
        margin-bottom: 20px;
    }
    input[type="text"],
    input[type="email"],
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
    input:focus {
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
    label.show-password {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #555;
        margin-top: 10px;
        cursor: pointer;
        user-select: none;
    }
    label.show-password input {
        margin-right: 8px;
        cursor: pointer;
    }
    .error-message {
        background-color: #ffe6e6;
        border: 1px solid #ff4d4d;
        color: #b30000;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 8px;
        text-align: left;
    }
    .success {
        background-color: #e6ffed;
        border: 1px solid #b2f2bb;
        color: #2f9e44;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
    }
    a {
        color: #007BFF;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<?php
require('db.php');
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = mysqli_real_escape_string($con, stripslashes($_POST['username']));
    $email = mysqli_real_escape_string($con, stripslashes($_POST['email']));
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Check password match
    if ($password !== $password_confirm) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters.";
    } else {
        $password_hashed = md5($password); // consider updating to password_hash()
        $trn_date = date("Y-m-d H:i:s");

        $query = "INSERT INTO `users` (username, password, email, trn_date)
                  VALUES ('$username', '$password_hashed', '$email', '$trn_date')";
        $result = mysqli_query($con, $query);

        if ($result) {
            $success_message = "You are registered successfully. <a href='login.php'>Click here to Login</a>";
        } else {
            $error_message = "Registration failed. Username or email might already exist.";
        }
    }
}
?>

<div class="form-container">
    <h1>Registration</h1>

    <?php if ($error_message): ?>
        <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
    <?php elseif ($success_message): ?>
        <div class="success"><?= $success_message ?></div>
    <?php endif; ?>

    <?php if (!$success_message): ?>
    <form action="" method="post" novalidate>
        <input type="text" name="username" placeholder="Username" required autocomplete="username" />
        <input type="email" name="email" placeholder="Email" required autocomplete="email" />
        <input type="password" name="password" id="password" placeholder="Password" required autocomplete="new-password" />
        <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm Password" required autocomplete="new-password" />

        <label class="show-password">
            <input type="checkbox" id="showPasswordToggle" />
            Show Passwords
        </label>

        <input type="submit" value="Register" />
    </form>
    <?php endif; ?>
</div>

<script>
    const toggle = document.getElementById('showPasswordToggle');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');

    toggle.addEventListener('change', () => {
        const type = toggle.checked ? 'text' : 'password';
        password.type = type;
        passwordConfirm.type = type;
    });
</script>

</body>
</html>
