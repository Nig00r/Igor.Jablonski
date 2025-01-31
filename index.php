<?php
session_start();


$correct_login = "admin";
$correct_password = "test";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"] ?? '';
    $password = $_POST["password"] ?? '';

    if ($login === $correct_login && $password === $correct_password) {
        $_SESSION["loggedin"] = true;
        $_SESSION["user"] = $login;
        header("Location: welcome.php"); 
        exit();
    } else {
        $error = "Nieprawidłowy login lub hasło.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
    <h2>Logowanie</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" action="login.php">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>
        <br>
        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Zaloguj</button>
    </form>
</body>
</html>