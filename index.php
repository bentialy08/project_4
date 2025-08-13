<?php
// Include auth.php file on all secure pages
include("auth.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Welcome Home</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f9fafb;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    padding: 40px 10px;
  }
  .container {
    max-width: 600px;
    background: white;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgb(0 0 0 / 0.1);
    width: 100%;
  }
  h1, h3 {
    color: #333;
    margin-top: 0;
  }
  p.welcome {
    font-size: 1.2rem;
    color: #555;
  }
  form {
    margin-top: 25px;
  }
  label {
    display: block;
    margin-top: 15px;
    font-weight: 600;
    color: #444;
  }
  input[type="text"],
  textarea {
    width: 100%;
    padding: 10px 12px;
    margin-top: 6px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
    resize: vertical;
    transition: border-color 0.3s;
  }
  input[type="text"]:focus,
  textarea:focus {
    border-color: #007BFF;
    outline: none;
  }
  input[type="submit"] {
    margin-top: 20px;
    background-color: #007BFF;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    transition: background-color 0.3s;
  }
  input[type="submit"]:hover {
    background-color: #0056b3;
  }
  nav a {
    display: inline-block;
    margin: 15px 10px 0 0;
    color: #007BFF;
    text-decoration: none;
    font-weight: 600;
  }
  nav a:hover {
    text-decoration: underline;
  }
  .logout-link {
    display: inline-block;
    margin-top: 25px;
    font-weight: 600;
    color: #d9534f;
    text-decoration: none;
  }
  .logout-link:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<div class="container">
  <p class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

  <h1>Discussion Forum</h1>
  <h3>Emojis and memes coming soon...</h3>

  <h3>Write A Discussion</h3>
  <form action="overwrite_file.php" method="POST">
    <label for="field1">First Name:</label>
    <input name="field1" id="field1" type="text" required />

    <label for="field2">Last Name:</label>
    <input name="field2" id="field2" type="text" required />

    <label for="field3">Begin discussion...</label>
    <textarea id="field3" name="field3" maxlength="140" placeholder="140 characters" required></textarea>

    <input type="submit" name="submit" value="Post Discussion" />
  </form>

  <nav>
    <a href="register_city.php">Register your favorite places with us</a>
    <a href="index.html">Go back to Home</a>
  </nav>

  <a href="logout.php" class="logout-link">Logout</a>
</div>

</body>
</html>
