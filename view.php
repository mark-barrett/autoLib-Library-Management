<?php
include 'header.php';

$user = new User();
$books = new Books();
$user->authenticate();

if(isset($_GET["delete"]) && !empty($_GET["delete"])) {
	$books->deleteReservation($_GET["delete"]);
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>autoLib - Reserve a Book</title>
</head>

<body>

<?php 
/* Use PHP and the basename method.
By using this and the __FILE__ arguement we can figure out which page is being visited, so the menu.php file can figure out which pages are to be displayed as active. */
$pageName = basename(__FILE__);
include 'menu.php'; 
?>
<div style="margin-left:25%;padding:1px 16px;height:100%;">
<h2><div class="right"><a href="logout.php">Logout</a></div>View Reserved Books</h2>
<hr/>
<p>Here is a list of the books you have reserved</p>
<?php 

if(isset($_GET["deleted"]) && !empty($_GET["deleted"]) && $_GET["deleted"] == "yes") {
	echo '<div class="success"><p class="center">Reservation deleted successfully</p></div><br/>';
}

$books->displayReservedBooks($_SESSION["username"]); ?>


</div>
    <?php include 'footer.php'; ?>
</body>

</html>