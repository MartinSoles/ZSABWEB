<?php

session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("Location: admin.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = 'ZSAB'; 
    $password = '123'; 

    if($_POST['username'] === $username && $_POST['password'] === $password) {
        $_SESSION['loggedin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Neplatné uživatelské jméno nebo heslo!";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/style.css" />
    <title>Přihlášení</title>
</head>

<body>
<h2>Přihlášení</h2>
    
        
        <form  class="login-main" method="post">
            <div>
                <label for="username">Jméno:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Heslo:</label>
                <input type="password" id="password" name="password" required>
            </div>

                <button id="login-button" type="submit">Přihlásit se</button>

        </form>

    <?php if(isset($error)) { echo $error; } ?>
</body>

</html>