<?php
// Attempt MySQL server connection
$link = mysqli_connect("localhost", "bsaintju", "password123", "bsaintju");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

date_default_timezone_set('America/Chicago'); // CDT

$success_message = '';
$error_message = '';

// Only process if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape user inputs for security
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = $_POST['password']; // we'll hash it below, so no escaping needed here
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $city = mysqli_real_escape_string($link, $_POST['city']);
    $state = mysqli_real_escape_string($link, $_POST['state']);
    $country = mysqli_real_escape_string($link, $_POST['country']);
    $trn_date = date("Y-m-d H:i:s");

    // Validate minimum password length
    if (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } else {
        // Hash password securely
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Prepare insert query
        $sql = "INSERT INTO users (username, password, email, city, state, country, trn_date) 
                VALUES ('$username', '$password_hashed', '$email', '$city', '$state', '$country', '$trn_date')";

        if (mysqli_query($link, $sql)) {
            $success_message = "Record added successfully. You have added your favorite city.";
        } else {
            $error_message = "ERROR: Could not execute query. " . mysqli_error($link);
        }
    }
}

// Close connection at the end of the script
// (Or do it after the HTML if you want to keep it open for more queries)
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register Favorite Cities</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f8fafc;
    margin: 0; padding: 20px;
    display: flex;
    justify-content: center;
  }
  .form-container {
    max-width: 480px;
    background: #fff;
    padding: 30px 35px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    width: 100%;
  }
  h1 {
    margin-top: 0;
    color: #222;
    margin-bottom: 25px;
    text-align: center;
  }
  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 7px;
    font-size: 15px;
    box-sizing: border-box;
    transition: border-color 0.3s;
  }
  input:focus {
    border-color: #007BFF;
    outline: none;
  }
  input[type="submit"] {
    width: 100%;
    background-color: #007BFF;
    border: none;
    color: white;
    padding: 14px;
    font-size: 16px;
    border-radius: 7px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  input[type="submit"]:hover {
    background-color: #0056b3;
  }
  .message {
    padding: 12px;
    border-radius: 7px;
    margin-bottom: 20px;
    font-weight: 600;
    text-align: center;
  }
  .success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }
  .error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }
  .links {
    margin-top: 25px;
    text-align: center;
  }
  .links a {
    margin: 0 10px;
    color: #007BFF;
    text-decoration: none;
    font-weight: 600;
  }
  .links a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<div class="form-container">
  <h1>Register Your Favorite Cities</h1>

  <?php if ($success_message): ?>
    <div class="message success"><?= htmlspecialchars($success_message) ?></div>
  <?php elseif ($error_message): ?>
    <div class="message error"><?= htmlspecialchars($error_message) ?></div>
  <?php endif; ?>

  <form name="registration" action="" method="post" novalidate>
    <input type="text" name="username" placeholder="Username" required autocomplete="username" />
    <input type="email" name="email" placeholder="Email" required autocomplete="email" />
    <input type="password" name="password" placeholder="Password" required autocomplete="new-password" />

    <input type="text" name="city" placeholder="City" required />
    <input type="text" name="state" placeholder="State" required />
    <input type="text" name="country" placeholder="Country" required />

    <input type="submit" name="submit" value="Register" />
  </form>

  <div class="links">
    <p><a href="index.php">Home Discussion</a> | <a href="index.html">Back To Main Page</a> | <a href="logout.php">Logout</a></p>
  </div>
</div>

<?php mysqli_close($link); ?>

</body>
</html>
