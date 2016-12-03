<?php
include 'header.php';

$user = new User();
$books = new Books();

if(isset($_POST["username"]) && isset($_POST["password"])) {
	$user->login($_POST["username"], $_POST["password"]);
}

$user->authenticate();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>autoLib - Home</title>
</head>

<body>

<?php 
/* Use PHP and the basename method.
By using this and the __FILE__ arguement we can figure out which page is being visited, so the menu.php file can figure out which pages are to be displayed as active. */
$pageName = basename(__FILE__);
include 'menu.php'; 
?>
<div style="margin-left:25%;padding:1px 16px;height:100%;">
  <h2><div class="right"><a href="logout.php">Logout</a></div>Hey <small><?php echo $_SESSION["username"]; ?>, Welcome to autoLib.</small></h2>
  <hr/>
  <h3>Books</h3>
  <?php $books->displayBooks(); ?>
</div>
    <?php include 'footer.php'; ?>
</body>

</html>