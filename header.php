<?php
session_start();
include 'classes/User.php';
include 'classes/Books.php';

$connection = new mysqli("localhost", "root", "", "book");

if(!$connection) {
	echo "Cannot connect to database";
}

?>