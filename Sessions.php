<?php
session_start();

if (!isset($_SESSION['softDrink'])) {
    $_SESSION['softDrink'] = 0;
}
if (!isset($_SESSION['milk'])) {
    $_SESSION['milk'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $worker = $_POST['worker'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity']; 
    $_SESSION["worker"] = $worker;

    if (isset($_POST["add"])) {
        switch ($product) {
            case 'milk':
                $_SESSION['milk'] += $quantity;
                break;
            case 'softDrink':
                $_SESSION['softDrink'] += $quantity;
                break;
            default:
                echo "<br><span style='color: red;'>Error: Product not found.</span>";
                break;
        }
    } elseif (isset($_POST["remove"])) {
        switch ($product) {
            case 'milk':
                if ($_SESSION['milk'] - $quantity < 0) {
                    echo "<br><span style='color: red;'>Error: Not possible to remove more quantity than what we have stored.</span>";
                } else {
                    $_SESSION['milk'] -= $quantity;
                }
                break;
            case 'softDrink':
                if ($_SESSION['softDrink'] - $quantity < 0) {
                    echo "<br><span style='color: red;'>Error: Not possible to remove more quantity than what we have stored.</span>";
                } else {
                    $_SESSION['softDrink'] -= $quantity;
                }
                break;
            default:
                echo "<br><span style='color: red;'>Error: Product not found.</span>";
                break;
        }
    } elseif (isset($_POST['reset'])) {
        $_SESSION['softDrink'] = 0;
        $_SESSION['milk'] = 0;
    }
}  
?>
<!DOCTYPE html>
<html>

<head>
    <title>Supermarket Management</title>
</head>

<body>
    <form action="" method="POST">
        <h1>Supermarket Management</h1>
        <label for="worker">Worker name:</label>
        <input type="text" id="worker" name="worker" value="<?php echo isset($_SESSION["worker"]) ? htmlspecialchars($_SESSION["worker"]) : ''; ?>" required>
        <h2>Choose a product:</h2>
        <select name="product" id="product">
            <option value="milk">Milk</option>
            <option value="softDrink">Soft Drink</option>
        </select>
        <h2>Product quantity:</h2>
        <input type="number" id="quantity" name="quantity" min="1" required><br><br>
        <input type="submit" value="Add" name="add">
        <input type="submit" value="Remove" name="remove">
        <input type="submit" value="Reset" name="reset">
    </form>
    <h2>Inventory:</h2>
    <p>Worker: <?php echo isset($_SESSION["worker"]) ? htmlspecialchars($_SESSION["worker"]) : ''; ?></p>
    <p>Units of Milk: <?php echo isset($_SESSION["milk"]) ? $_SESSION["milk"] : ''; ?></p>
    <p>Units of Soft Drink: <?php echo isset($_SESSION["softDrink"]) ? $_SESSION["softDrink"] : ''; ?></p>
</body>

</html>
