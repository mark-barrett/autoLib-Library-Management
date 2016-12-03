<ul>
<h1>&nbsp;autoLib</h1>
<?php
//Use $pageName variable to determine which page the user is on
if($pageName == "home.php") {
	echo '<li><a class="active" href="">Home</a></li>';
	echo '<li><a class="" href="search.php">Search for Book</a></li>';
	echo '<li><a class="" href="reserve.php">Reserve a Book</a></li>';
	echo '<li><a class="" href="view.php">View Reserved Books</a></li>';
}
else if($pageName == "search.php") {
	echo '<li><a class="" href="home.php">Home</a></li>';
	echo '<li><a class="active" href="search.php">Search for Book</a></li>';
	echo '<li><a class="" href="reserve.php">Reserve a Book</a></li>';
	echo '<li><a class="" href="view.php">View Reserved Books</a></li>';
}
else if($pageName == "reserve.php") {
	echo '<li><a class="" href="home.php">Home</a></li>';
	echo '<li><a class="" href="search.php">Search for Book</a></li>';
	echo '<li><a class="active" href="reserve.php">Reserve a Book</a></li>';
	echo '<li><a class="" href="view.php">View Reserved Books</a></li>';
}
else if($pageName == "view.php") {
	echo '<li><a class="" href="home.php">Home</a></li>';
	echo '<li><a class="" href="search.php">Search for Book</a></li>';
	echo '<li><a class="" href="reserve.php">Reserve a Book</a></li>';
	echo '<li><a class="active" href="view.php">View Reserved Books</a></li>';
}
?>
</ul>