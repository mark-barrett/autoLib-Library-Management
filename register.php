<?php
include 'header.php';

//Instantiate a new User object
$user = new User();

//Check to see that all relevant fields in the form were set
if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"]) && isset($_POST["firstName"]) && isset($_POST["surname"]) && isset($_POST["addressLine1"]) && isset($_POST["city"]) && isset($_POST["telephone"]) && isset($_POST["mobile"])) {

    if(!is_numeric($_POST["mobile"]) || strlen($_POST["mobile"]) != 10) {
        Header("Location: register.php?error=mobile");
    }
    else {

        if(strlen($_POST["password"]) != 6 && strlen($_POST["confirmPassword"]) !=6) {
            Header("Location: register.php?error=passwordlength");
        }
        else {

            if(strcmp($_POST["password"], $_POST["confirmPassword"]) == 0) {
                //If the second address line was choosen not to be entered, set it to a blank value
                if(empty($_POST["addressLine2"])) {
                    $addressLine2 = " ";
                }
                //If it was enetered retrieve the data from the post.
                else {
                    $addressLine2 = $_POST["addressLine2"];
                }

                //Register the user
                $user->registerUser($_POST["username"], $_POST["password"], $_POST["firstName"], $_POST["surname"], $_POST["addressLine1"], $addressLine2, $_POST["city"], $_POST["telephone"], $_POST["mobile"]);
            }
            else {
                Header("Location: register.php?error=passwordnomatch");
            }
        }
    }

}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>autoLib - Register</title>
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

    if(isset($_GET["error"]) && $_GET["error"] == "username") {
        echo '<br/><div class="error"><p class="center">User with that name already exists</p></div><br/>';
    }
    else if(isset($_GET["error"]) && $_GET["error"] == "mobile") {
        echo '<br/><div class="error"><p class="center">The value entered for mobile was not numeric or not 10 digits in length</p></div><br/>';
    }
    else if(isset($_GET["error"]) && $_GET["error"] == "passwordlength") {
        echo '<br/><div class="error"><p class="center">Password must be 6 characters in length</p></div><br/>';
    }
    else if(isset($_GET["error"]) && $_GET["error"] == "passwordnomatch") {
        echo '<br/><div class="error"><p class="center">Passwords do not match</p></div><br/>';
    }
    else {
        '<br/>';
    }
    ?>
    <div class="register">
        <h1 class="center">autoLib - <small>Register</small></h1>
        <div class="center">
            <form name="register" method="POST" action="">
                <input type="text" name="username" required="required" placeholder="Your Username">
                <br/>
                <br/>
                <input type="password" name="password" required="required" placeholder="Your Password">
                <br/>
                <br/>
                <input type="password" name="confirmPassword" required="required" placeholder="Confirm Password">
                <br/>
                <br/>
                <input type="text" name="firstName" required="required" placeholder="First Name">
                <br/>
                <br/>
                <input type="text" name="surname" required="required" placeholder="Surname">
                <br/>
                <br/>
                <input type="text" name="addressLine1" required="required" placeholder="Address Line 1">
                <br/>
                <br/>
                <input type="text" name="addressLine2" placeholder="Address Line 2">
                <br/>
                <br/>
                <input type="text" name="city" required="required" placeholder="City">
                <br/>
                <br/>
                <input type="text" name="telephone" required="required" placeholder="Telephone">
                <br/>
                <br/>
                <input type="text" name="mobile" required="required" placeholder="Mobile">
                <br/>
                <br/>
                <input type="submit" value="Register">
                <p>Already have an account? <a href="login.php">Login</a> now</p>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>