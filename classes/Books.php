<?php
class Books {

	public function displayBooks() {
		global $connection;

		if (isset($_GET["page"])) { 
			$page  = $_GET["page"]; 
		} 
		else { 
			$page=1; 
		}

		$stmt = $connection->prepare("SELECT COUNT(ISBN) AS total FROM books");
		$stmt->execute();
		$stmt->bind_result($totalResults);
		$stmt->fetch();
		$stmt->close();

		$resultsPerPage = 5;
		$totalPages = ceil($totalResults / $resultsPerPage);

		$startFrom = ($page-1) * $resultsPerPage;

		$stmt = $connection->prepare("SELECT * FROM books LIMIT ?,?");
		$stmt->bind_param("ii", $startFrom, $resultsPerPage);
		$stmt->execute();
		$stmt->bind_result($ISBN, $bookTitle, $author, $edition, $year, $category, $reserved);

		echo '<table>';
		echo '<tr><th>ISBN</th><th>Book Title</th><th>Author</th><th>Edition</th><th>Year</th><th>Category</th><th>Reserved</th></tr>';
		while($stmt->fetch()) {
			echo '<tr>';
			echo '<td>'.$ISBN.'</td>';
			echo '<td>'.$bookTitle.'</td>';
			echo '<td>'.$author.'</td>';
			echo '<td>'.$edition.'</td>';
			echo '<td>'.$year.'</td>';
			echo '<td>'.$category.'</td>';
			echo '<td>'.($reserved == 'N' ? '<a href="reserve.php?isbn='.$ISBN.'">Availible for reservation</a>' : 'Not availibe').'</td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '<p>Pages: ';
		for ($i=1; $i<=$totalPages; $i++) { 
    		echo "<a href='home.php?page=".$i."'>".$i."&nbsp;</a> "; 
		}
		echo '</p>';
		$stmt->close();
	}

	public function categoryOptions() {
		global $connection;

		$categoryID = "";
		$categoryDescription = "";

		$stmt = $connection->prepare("SELECT description FROM category");
		$stmt->execute();
		$stmt->bind_result($categoryDescription);

		echo '<option>All Categories</option>';
		while($stmt->fetch()) {
			echo '<option>'.$categoryDescription.'</option>';
		}
		echo '</table>';
		$stmt->close();
	}

	public function searchByCategory($category, $searchQuery) {
		global $connection;

		if($category == "All Categories") {

			if (isset($_GET["page"])) { 
			$page  = $_GET["page"]; 
		} 
		else { 
			$page=1; 
		}

		$searchQuery = "%".$searchQuery;
		$searchQuery .= "%";


		$stmt = $connection->prepare("SELECT COUNT(ISBN) AS total FROM books WHERE book_title LIKE ? OR author LIKE ?");
		$stmt->bind_param("ss", $searchQuery, $searchQuery);
		$stmt->execute();
		$stmt->bind_result($totalResults);
		$stmt->fetch();
		$stmt->close();
		
		$resultsPerPage = 5;
		$totalPages = ceil($totalResults / $resultsPerPage);

		$startFrom = ($page-1) * $resultsPerPage;

		$stmt = $connection->prepare("SELECT * FROM books WHERE book_title LIKE ? OR author LIKE ? LIMIT ?,?");
		
		$stmt->bind_param("ssii", $searchQuery, $searchQuery, $startFrom, $resultsPerPage);
		$stmt->execute();
		$stmt->bind_result($ISBN, $bookTitle, $author, $edition, $year, $category, $reserved);
		$stmt->store_result();

		echo '<table>';
		echo '<tr><th>ISBN</th><th>Book Title</th><th>Author</th><th>Edition</th><th>Year</th><th>Category</th><th>Reserved</th></tr>';
		while($stmt->fetch()) {
			echo '<tr>';
			echo '<td>'.$ISBN.'</td>';
			echo '<td>'.$bookTitle.'</td>';
			echo '<td>'.$author.'</td>';
			echo '<td>'.$edition.'</td>';
			echo '<td>'.$year.'</td>';
			echo '<td>'.$category.'</td>';
			echo '<td>'.($reserved == 'N' ? '<a href="reserve.php?isbn='.$ISBN.'">Availible for reservation</a>' : 'Not availibe').'</td>';
			echo '</tr>';
		}
	echo '</table>';
	echo '<p>Pages: ';
		for ($i=1; $i<=$totalPages; $i++) { 
    		echo "<a href='search.php?page=".$i."'>".$i."&nbsp;</a> "; 
		}
		echo '</p>';

	$stmt->close();

		}
		else {
			$categoryID = 0;

		//Find the categories id
		$stmt = $connection->prepare("SELECT id FROM category WHERE description = ?");
		$stmt->bind_param("s", $category);
		$stmt->execute();
		$stmt->bind_result($categoryID);
		$stmt->fetch();
		$stmt->close();

		$searchQuery = "%".$searchQuery;
		$searchQuery .= "%";

		$stmt = $connection->prepare("SELECT * FROM books WHERE book_title LIKE ? AND category = ? OR author LIKE ? AND category = ?");
		
		$stmt->bind_param("sisi", $searchQuery, $categoryID, $searchQuery, $categoryID);
		$stmt->execute();
		$stmt->bind_result($ISBN, $bookTitle, $author, $edition, $year, $category, $reserved);

		echo '<table>';
		echo '<tr><th>ISBN</th><th>Book Title</th><th>Author</th><th>Edition</th><th>Year</th><th>Category</th><th>Reserved</th></tr>';
		while($stmt->fetch()) {
			echo '<tr>';
			echo '<td>'.$ISBN.'</td>';
			echo '<td>'.$bookTitle.'</td>';
			echo '<td>'.$author.'</td>';
			echo '<td>'.$edition.'</td>';
			echo '<td>'.$year.'</td>';
			echo '<td>'.$category.'</td>';
			echo '<td>'.($reserved == 'N' ? '<a href="reserve.php?isbn='.$ISBN.'">Availible for reservation</a>' : 'Not availibe').'</td>';
			echo '</tr>';
		}
	echo '</table>';

	$stmt->close();
		}
	}

	public function displayAvailibleBooks() {
		global $connection;

		$reserved = 'N';

		if (isset($_GET["page"])) { 
			$page  = $_GET["page"]; 
		} 
		else { 
			$page=1; 
		};

		$stmt = $connection->prepare("SELECT COUNT(ISBN) AS total FROM books WHERE reserved = ?");
		$stmt->bind_param("s",$reserved);
		$stmt->execute();
		$stmt->bind_result($totalResults);
		$stmt->fetch();
		$stmt->close();

		$resultsPerPage = 5;
		$totalPages = ceil($totalResults / $resultsPerPage);

		$startFrom = ($page-1) * $resultsPerPage;


		$stmt = $connection->prepare("SELECT * FROM books WHERE reserved = ? LIMIT ?,?");
		$stmt->bind_param("sii", $reserved, $startFrom, $resultsPerPage);
		$stmt->execute();
		$stmt->bind_result($ISBN, $bookTitle, $author, $edition, $year, $category, $reserved);

		echo '<table>';
		echo '<tr><th>ISBN</th><th>Book Title</th><th>Author</th><th>Edition</th><th>Year</th><th>Category</th><th>Reserved</th></tr>';
		while($stmt->fetch()) {
			echo '<tr>';
			echo '<td>'.$ISBN.'</td>';
			echo '<td>'.$bookTitle.'</td>';
			echo '<td>'.$author.'</td>';
			echo '<td>'.$edition.'</td>';
			echo '<td>'.$year.'</td>';
			echo '<td>'.$category.'</td>';
			echo '<td>'.($reserved == 'N' ? '<a href="reserve.php?isbn='.$ISBN.'">Click to reserve</a>' : 'Not availibe').'</td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '<p>Pages: ';
		for ($i=1; $i<=$totalPages; $i++) { 
    		echo "<a href='reserve.php?page=".$i."'>".$i."&nbsp;</a> "; 
		}
		echo '</p>';
		$stmt->close();
	}

	public function reserveBook($isbn, $user) {
		global $connection;

		$status = 'Y';

		//Firstly add the reservation to the list
		$stmt = $connection->prepare("INSERT INTO reservations (ISBN, username) VALUES (?, ?)");
		$stmt->bind_param("ss", $isbn, $user);
		$stmt->execute();
		$stmt->close();

		//Now set the reservation status of the book to taken
		$stmt = $connection->prepare("UPDATE books SET reserved = ? WHERE ISBN = ?");
		$stmt->bind_param("ss", $status, $isbn);
		$stmt->execute();
		$stmt->close();
	}

	public function displayReservedBooks($username) {
		global $connection;

		$stmt = $connection->prepare("SELECT reservations.reserved_date AS reservations_date, books.* FROM reservations INNER JOIN books ON reservations.ISBN = books.ISBN WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($reservedDate, $ISBN, $bookTitle, $author, $edition, $year, $category, $reserved);

		echo '<table>';
		echo '<tr><th>ISBN</th><th>Book Title</th><th>Author</th><th>Edition</th><th>Year</th><th>Category</th><th>Reservation Date</th><th>Action</th></tr>';

		while($stmt->fetch()) {
			echo '<tr>';
			echo '<td>'.$ISBN.'</td>';
			echo '<td>'.$bookTitle.'</td>';
			echo '<td>'.$author.'</td>';
			echo '<td>'.$edition.'</td>';
			echo '<td>'.$year.'</td>';
			echo '<td>'.$category.'</td>';
			echo '<td>'.$reservedDate.'</td>';
			echo '<td><a href="view.php?delete='.$ISBN.'">Delete Reservation</a></td>';
			echo '</tr>';

		}
		echo '</table>';
		$stmt->close();
	}

	public function deleteReservation($isbn) {
		global $connection;

		//First delete the reservation from the list
		$stmt = $connection->prepare("DELETE FROM reservations WHERE ISBN = ?");
		$stmt->bind_param("s", $isbn);

		if($stmt->execute()) {
			$stmt->close();
			$reserved = 'N';
			//Unmark the book as being out for reservation
			$stmt = $connection->prepare("UPDATE books SET reserved = ? WHERE ISBN = ?");
			$stmt->bind_param("ss", $reserved, $isbn);

			if($stmt->execute()) {
				Header("Location: view.php?deleted=yes");
			}
		}
		$stmt->close();
	}

}
?>