<?php
session_start();


if (!isset($_SESSION['array'])) {
    $_SESSION['array'] = [10, 20, 30];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['modify'])) {
        $position = intval($_POST['position']);
        $newValue = intval($_POST['value']);
        if (isset($_SESSION['array'][$position])) {
            $_SESSION['array'][$position] = $newValue;
        }
    } elseif (isset($_POST['average'])) {
        $average = array_sum($_SESSION['array']) / count($_SESSION['array']);
    } elseif (isset($_POST['reset'])) {
        $_SESSION['array'] = [10, 20, 30];
    }
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify array saved in session</title>
</head>
<body>

    <h2>Modify array saved in session</h2>

<form method="post">
    <label for="position">Position to modify:</label>
    <select name="position">
        <?php foreach ($_SESSION['array'] as $index => $value): ?>
            <option value="<?= $index ?>"><?= $index ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label for="value">New value:</label>
    <input type="text" name="value" required>

    <br><br>

    <button type="submit" name="modify">Modify</button>
    <button type="submit" name="average">Average</button>
    <button type="submit" name="reset">Reset</button>
</form>

<p>Current array: <?= implode(", ", $_SESSION['array']) ?></p>

<?php if (isset($average)): ?>
    <h3>Average: <?= $average ?></h3>
<?php endif; ?>


</body>
</html>
