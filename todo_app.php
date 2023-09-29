<?php

function register()
{
    $users = json_decode(file_get_contents('user.json'), true);
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    
    $id = uniqid();
    
    
    $user = [
        'id' => $id,
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ];
    
    
    $users[] = $user;
    
    
    file_put_contents('user.json', json_encode($users));
    
    echo 'Registration successful!';
}
?>

<?php

function login()
{
    $users = json_decode(file_get_contents('user.json'), true);
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    
    $user = array_filter($users, function($u) use ($email) {
        return $u['email'] === $email;
    });
    
    if (count($user) === 1) {
        $user = reset($user);
        
        
        if (password_verify($password, $user['password'])) {
            echo 'Login successful!';
            
        } else {
            echo 'Invalid password!';
        }
    } else {
        echo 'User not found!';
    }
}
?>
<?php

function main()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['register'])) {
            register();
        } elseif (isset($_POST['login'])) {
            login();
        }
    }
}

main();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Todo App</title>
</head>
<body>
    <h1>Registration</h1>
    <form method="POST" action="todo_app.php">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        
        <input type="submit" name="register" value="Register">
    </form>
    
    <h1>Login</h1>
    <form method="POST" action="todo_app.php">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>



