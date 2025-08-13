<?php
session_start();
$connect = mysqli_connect("localhost", "bsaintju", "password123", "bsaintju");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["add"])) {
    $product_id = $_GET["id"];
    $quantity = (int)$_POST["quantity"];

    if (isset($_SESSION["cart"])) {
        $item_array_id = array_column($_SESSION["cart"], "product_id");

        if (!in_array($product_id, $item_array_id)) {
            $count = count($_SESSION["cart"]);
            $item_array = array(
                'product_id' => $product_id,
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $quantity > 0 ? $quantity : 1
            );
            $_SESSION["cart"][$count] = $item_array;
        } else {
            echo '<script>alert("Product already added to cart")</script>';
        }
    } else {
        $item_array = array(
            'product_id' => $product_id,
            'item_name' => $_POST["hidden_name"],
            'product_price' => $_POST["hidden_price"],
            'item_quantity' => $quantity > 0 ? $quantity : 1
        );
        $_SESSION["cart"][0] = $item_array;
    }

    echo '<script>window.location="cart_index.php"</script>';
    exit();
}

if (isset($_GET["action"])) {
    $product_id = $_GET["id"];

    if ($_GET["action"] == "delete") {
        if (!empty($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $keys => $values) {
                if ($values["product_id"] == $product_id) {
                    unset($_SESSION["cart"][$keys]);
                    // Reindex array to prevent gaps
                    $_SESSION["cart"] = array_values($_SESSION["cart"]);
                    echo '<script>alert("Product has been removed")</script>';
                    echo '<script>window.location="cart_index.php"</script>';
                    exit();
                }
            }
        }
    }

    if ($_GET["action"] == "update" && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_quantity = (int)$_POST['quantity'];
        if ($new_quantity < 1) {
            $new_quantity = 1;
        }
        if (!empty($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $keys => $values) {
                if ($values["product_id"] == $product_id) {
                    $_SESSION["cart"][$keys]["item_quantity"] = $new_quantity;
                    echo '<script>alert("Quantity updated")</script>';
                    echo '<script>window.location="cart_index.php"</script>';
                    exit();
                }
            }
        }
    }
}
?>
