<?php
include 'header.php';

$user = new User();
$books = new Books();
$user->authenticate();

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>autoLib - Search for a Book</title>
</head>

<body>

<?php 
/* Use PHP and the basename method.
By using this and the __FILE__ arguement we can figure out which page is being visited, so the menu.php file can figure out which pages are to be displayed as active. */
$pageName = basename(__FILE__);
include 'menu.php'; 
?>
<div style="margin-left:25%;padding:1px 16px;height:100%;">

  <h2><div class="right"><a href="logout.php">Logout</a></div>Search for a Book</h2>
  <hr/>
<h3>Search by Category</h3>
  <form name="searchCategory" method="POST" action="">
  <p>Category:</p>
  <select name="categoryName">
  <?php
$books->categoryOptions();
  ?></select><br/><br/>
    <input type="text" name="searchQuery" required="required" placeholder="Query within category">
    <br/>
    <br/>
    <input type="submit" value="Search">
</form>
<?php
//If either way of searching has been selected
if(isset($_POST["searchQuery"]) && !empty($_POST["searchQuery"])) {

	//If searching by category
	if(isset($_POST["categoryName"]) && !empty($_POST["categoryName"])) {
		echo '<p>Results for search "'. $_POST["searchQuery"].'" in category '.$_POST["categoryName"];
		$books->searchByCategory($_POST["categoryName"], $_POST["searchQuery"]);
	}
}

?>






</div>
    <?php include 'footer.php'; ?>
</body>

</html>