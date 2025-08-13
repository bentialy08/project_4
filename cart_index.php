<?php
session_start();
$connect = mysqli_connect("localhost", "bsaintju", "password123", "bsaintju");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Shopping Cart</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<body>
    <div class="container" style="max-width: 960px;">
        <h2 class="text-center my-4">Online Shopping Cart</h2>

        <div class="row">
            <?php
            $query = "SELECT * FROM products ORDER BY id ASC";
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                        <form method="post" action="shop.php?action=add&id=<?php echo $row["id"]; ?>">
                            <div class="border shadow-sm p-3 text-center">
                                <img src="<?php echo htmlspecialchars($row["image"]); ?>"
                                    alt="<?php echo htmlspecialchars($row["p_name"]); ?>" class="img-fluid mb-3" />
                                <h5 class="text-info"><?php echo htmlspecialchars($row["p_name"]); ?></h5>
                                <h5 class="text-danger">$<?php echo number_format($row["price"], 2); ?></h5>
                                <input type="number" name="quantity" class="form-control mb-2" value="1" min="1" />
                                <input type="hidden" name="hidden_name"
                                    value="<?php echo htmlspecialchars($row["p_name"]); ?>" />
                                <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
                                <input type="submit" name="add" class="btn btn-success btn-block" value="Add to Bag" />
                            </div>
                        </form>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <h2 class="my-4">My Shopping Bag</h2>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="40%">Product Name</th>
                        <th width="15%">Quantity</th>
                        <th width="20%">Price Details</th>
                        <th width="15%">Order Total</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION["cart"])) {
                        $total = 0;
                        foreach ($_SESSION["cart"] as $keys => $values) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($values["item_name"]); ?></td>
                                <td>
                                    <form method="post" action="shop.php?action=update&id=<?php echo $values["product_id"]; ?>"
                                        class="d-flex align-items-center">
                                        <input type="number" name="quantity"
                                            value="<?php echo (int) $values["item_quantity"]; ?>" min="1"
                                            class="form-control form-control-sm me-2" style="width: 80px;" required />
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                                <td>$<?php echo number_format($values["product_price"], 2); ?></td>
                                <td>$<?php echo number_format($values["item_quantity"] * $values["product_price"], 2); ?></td>
                                <td><a href="shop.php?action=delete&id=<?php echo $values["product_id"]; ?>"
                                        class="btn btn-danger btn-sm">Remove</a></td>
                            </tr>
                            <?php
                            $total += $values["item_quantity"] * $values["product_price"];
                        }
                        ?>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="fw-bold">$<?php echo number_format($total, 2); ?></td>
                            <td></td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">Your shopping bag is empty.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end align-items-center my-4">
            <a href="" class="btn btn-primary btn-lg">Checkout</a>
        </div>

    </div>
</body>

</html>