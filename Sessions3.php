<?php 
session_start();  

if (!isset($_SESSION['shopping_list'])) { 
    $_SESSION['shopping_list'] = []; 
}  


$name = $quantity = $price = ""; 
$index = -1; 
$message = ""; 
$error = ""; 
$totalValue = 0; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {     
    if (isset($_POST['add']) && isset($_POST['name']) && isset($_POST['quantity']) && isset($_POST['price'])) {         
        $name = trim($_POST['name']);         
        $quantity =  $_POST['quantity'];         
        $price = $_POST['price'];          

        if ($name === "" || $quantity <= 0 || $price <= 0) {             
            $error = "Please enter a valid name, quantity, and price.";         
        } else {             
            //verificamos si el nombre ya existe para que no se pueda volver a añadir.
            $exists = false;
            foreach ($_SESSION['shopping_list'] as $item) {
                if ($item['name'] === $name) { 
                    $exists = true;
                    break;
                }
            }

            if ($exists) {
                $error = "The item '$name' already exists.";
            } else {
                $_SESSION['shopping_list'][] = ['name' => $name, 'quantity' => $quantity, 'price' => $price];             
                $message = "Item added properly.";   
            }
        }     
    } elseif (isset($_POST['edit']) && isset($_POST['index'])) {         
        $index = (int) $_POST['index'];         
        if (isset($_SESSION['shopping_list'][$index])) {             
            $name = $_SESSION['shopping_list'][$index]['name'];             
            $quantity = $_SESSION['shopping_list'][$index]['quantity'];             
            $price = $_SESSION['shopping_list'][$index]['price'];         
        }     
    } elseif (isset($_POST['update']) && isset($_POST['index']) && $_POST['index'] >= 0) {         
        $index = $_POST['index'];         
        if (isset($_SESSION['shopping_list'][$index])) {             
            $_SESSION['shopping_list'][$index] = [                 
                'name' => $_POST['name'],                 
                'quantity' => $_POST['quantity'],                 
                'price' => $_POST['price']             
            ];             
            $message = "Item updated properly.";         
        }     
    } elseif (isset($_POST['delete']) && isset($_POST['index'])) {         
        $index =  $_POST['index'];         
        if (isset($_SESSION['shopping_list'][$index])) {             
            array_splice($_SESSION['shopping_list'], $index, 1);             
            $message = "Item deleted properly.";         
        }     
    } elseif (isset($_POST['reset'])) {         
        $_SESSION['shopping_list'] = [];         
        $message = "Reseted.";     
    } elseif (isset($_POST['calculate_total'])) { 
        foreach ($_SESSION['shopping_list'] as $item) {     
            $totalValue += $item['quantity'] * $item['price']; 
        }
    }
} 
?>

<!DOCTYPE html>
<html>

<head>
    <title>Shopping list</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
        }

        input[type=submit] {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Shopping list</h1>
    <form method="post">
        <label for="name">name:</label>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>">
        <br>
        <label for="quantity">quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>">
        <br>
        <label for="price">price:</label>
        <input type="number" name="price" id="price" value="<?php echo $price; ?>">
        <br>
        <input type="hidden" name="index" value="<?php echo $index; ?>">
        <input type="submit" name="add" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="reset" value="Reset">
    </form>
    <p style="color:red;"><?php echo $error; ?></p>
    <p style="color:green;"><?php echo $message; ?></p>
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>cost</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['list'] as $index => $item) { ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $item['quantity'] * $item['price']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="name" value="<?php echo $item['name']; ?>">
                            <input type="hidden" name="quantity" value="<?php echo $item['quantity']; ?>">
                            <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <input type="submit" name="edit" value="Edit">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><?php echo $totalValue; ?></td>
                <td>
                    <form method="post">
                    <input type="submit" name="calculate_total" value="Calculate Total">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
