<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>autoLib - Login</title>
</head>

<body>
    <div class="topStrip">
    </div>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <?php
    if(isset($_GET["registration"]) && $_GET["registration"] == "successful") {

    	echo '<div class="success"><p class="center">Registration successful. You can now login</p></div><br/>';

    }
    else if(isset($_GET["login"]) && $_GET["login"] == "error") {

    echo '<div class="error"><p class="center">Your username or password was invalid</p></div><br/>';

    }
    else {
    	echo '<br/>';
    }
    ?>
    <div class="login">
        <h1 class="center">autoLib - <small>Login</small></h1>
        <div class="center">
            <form name="login" method="POST" action="home.php">
                <input type="text" name="username" required="required" placeholder="Your Username">
                <br/>
                <br/>
                <input type="password" name="password" required="required" placeholder="Your Password">
                <br/>
                <br/>
                <input type="submit" value="Login">
                <p>Don't have an account? <a href="register.php">Register</a> for one now</p>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>