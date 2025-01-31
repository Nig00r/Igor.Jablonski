<?php
session_start();


$host = "localhost";
$dbname = "your_database";
$user = "your_user";
$password = "your_password";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"], $_POST["password"])) {
        $login = $_POST["login"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($db_password);
            $stmt->fetch();
            if ($password === $db_password) {
                $_SESSION["loggedin"] = true;
                $_SESSION["user"] = $login;
                header("Location: welcome.php"); 
                exit();
            } else {
                $error = "Nieprawidłowy login lub hasło.";
            }
        } else {
            $error = "Nieprawidłowy login lub hasło.";
        }

        $stmt->close();
    }
}

$conn->close();
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