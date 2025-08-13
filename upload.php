<?php
if (isset($_POST["submit"])) {
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Limit file size (e.g. 5MB max)
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES["image"]["size"] > $maxFileSize) {
                echo "File is too large. Maximum allowed size is 5MB.";
                exit;
            }

            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imgContent = file_get_contents($imageTmpPath);

            $dbHost = 'localhost';
            $dbUsername = 'bsaintju';
            $dbPassword = 'password123';
            $dbName = 'bsaintju';

            // Create connection
            $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

            if ($db->connect_error) {
                die("Connection failed: " . htmlspecialchars($db->connect_error));
            }

            date_default_timezone_set('America/Chicago');
            $dateTime = date("Y-m-d H:i:s");

            // Prepare and bind
            $stmt = $db->prepare("INSERT INTO images (image, created) VALUES (?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . htmlspecialchars($db->error));
            }

            $stmt->bind_param("bs", $null, $dateTime);

            $stmt->send_long_data(0, $imgContent);

            if ($stmt->execute()) {
                echo "File uploaded successfully.<br>";
                $link_address = 'sell_continue.html';
                echo "<a href='" . htmlspecialchars($link_address) . "'>Click here to provide the rest of the info for the item</a>";
            } else {
                echo "File upload failed, please try again. Error: " . htmlspecialchars($stmt->error);
            }

            $stmt->close();
            $db->close();
        } else {
            echo "Please select a valid image file to upload.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}
?>
