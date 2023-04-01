<?php
session_start();
require_once __DIR__ . '/../classes/PDOProvider.php';

// if the user is already logged in, redirect to the index page
if (isset($_SESSION['login'])) {
    header("Location: /index.php"); // replace with your index page URL
    exit();
}

// if the form was submitted, try to log in the user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get the login and password from the form
    $login = $_POST['login'];
    $password = $_POST['password'];

    // get the PDO instance
    $pdo = PDOProvider::get();

    // prepare a query to find the user with the given login and password
    $stmt = $pdo->prepare('SELECT * FROM employee WHERE login = :login AND password = :password');
    $stmt->bindValue(':login', $login);
    $stmt->bindValue(':password', $password);
    $stmt->execute();

    // get the first row (should only be one) from the result set
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // if the user was found, set the session variables and redirect to the index page
    if ($user) {
        $_SESSION['login'] = $user['login'];
        $_SESSION['admin'] = $user['admin'];
        header("Location: /index.php"); // replace with your index page URL
        exit();
    }

    // if the user was not found, show an error message
    $error = 'Invalid login or password.';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<form method="post">
    <label>
        Login:
        <input type="text" name="login">
    </label>
    <br>
    <label>
        Password:
        <input type="password" name="password">
    </label>
    <br>
    <button type="submit">Log in</button>
</form>
</body>
</html>
