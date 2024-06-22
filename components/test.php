<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="test.php" method="post">
    Username: <input type="text" name="username" required><br>
Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>

<?php
$servername = "localhost";
$db_username = "root";
$db_password = "6jfmd672@V";
$dbname = "person_info";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM account_acc WHERE username = '$username'  ";
    $result = $conn->query($sql);
//    echo  $result-> num_rows;
//    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
//    echo  $password;
    if ( $result-> num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            echo "Login successfully";
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Invalid username or password";
    }


}

$conn->close();
?>