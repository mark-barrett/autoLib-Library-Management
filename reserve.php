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
<h2><div class="right"><a href="logout.php">Logout</a></div>Reserve a Book</h2>
<hr/>
<?php
if(isset($_GET["isbn"]) && !empty($_GET["isbn"])) {
  echo '<h3>Thank you! You have reserved the following:</h3>';

  $stmt = $connection->prepare("SELECT * FROM books WHERE isbn = ? LIMIT 1");
  $stmt->bind_param("s", $_GET["isbn"]);
  $stmt->execute();
  $stmt->bind_result($ISBN, $bookTitle, $author, $edition, $year, $category, $reserved);

  while($stmt->fetch()) {
    echo '<p><strong><u>ISBN</u></strong>: '.$ISBN.'</p>';
    echo '<p><strong><u>Book Title:</u></strong> '.$bookTitle.'</p>';
    echo '<p><strong><u>Author:</u></strong> '.$author.'</p>';
  }
  $books->reserveBook($_GET["isbn"], $_SESSION["username"]);
}
?>
<h3>Availible Books</h3>
<?php $books->displayAvailibleBooks(); ?>


</div>
    <?php include 'footer.php'; ?>
</body>

</html>