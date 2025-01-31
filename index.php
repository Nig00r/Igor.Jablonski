<?php
$plain_password = "mojehaslo";
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (username, password) VALUES ('uzytkownik1', '$hashed_password')";
$conn->query($sql);
?>

<?php
$input_username = "uzytkownik1";
$input_password = "mojehaslo";

$sql = "SELECT password FROM users WHERE username = '$input_username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $stored_hash = $user['password'];

    if (password_verify($input_password, $stored_hash)) {
        echo "Logowanie udane!";
    } else {
        echo "Nieprawidłowe dane logowania.";
    }
} else {
    echo "Użytkownik nie istnieje.";
}

?>

<?php
$plain_password = "mojehaslo";
$salt = uniqid();
$hashed_password = hash("sha256", $salt . $plain_password);
$sql = "INSERT INTO users (username, password, salt) VALUES ('uzytkownik1', '$hashed_password', '$salt')";
$conn->query($sql);
?>

<?php
$input_username = "uzytkownik1";
$input_password = "mojehaslo";

$sql = "SELECT password, salt FROM users WHERE username = '$input_username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $stored_hash = $user['password'];
    $salt = $user['salt'];
    $input_hash = hash("sha256", $salt . $input_password);

    if ($input_hash === $stored_hash) {
        echo "Logowanie udane!";
    } else {
        echo "Nieprawidłowe dane logowania.";
    }
} else {
    echo "Użytkownik nie istnieje.";
}

?>