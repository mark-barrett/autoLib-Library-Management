<?php
class User {
	public function registerUser($username, $password, $firstName, $surname, $addressLine1, $addressLine2, $city, $telephone, $mobile) {
		global $connection;

		//First check to see if the username has been used in the system before
		$stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();

		//If the username has been found, $stmt->num_rows will return a number greater than 0
		if($stmt->num_rows > 0) {
			//Display an error message
			Header("Location: register.php?error=username");
		}
		else {
			//If not found Enter the users information into the database.
			$stmt = $connection->prepare("INSERT INTO users (username, password, first_name, surname, address_line1, address_line2, city, telephone, mobile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssssss", $username, md5($password), $firstName, $surname, $addressLine1, $addressLine2, $city, $telephone, $mobile);
			

			if($stmt->execute()) {
				Header("Location: login.php?registration=successful");
			}
			else {
				echo '<p>There was an error registering you.</p>';
			}
		}
		
	}

	public function login($username, $password) {
		global $connection;
		$dbPassword = "";

		//First check to see if the username has been used in the system before
		$stmt = $connection->prepare("SELECT password FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($dbPassword);
		$stmt->fetch();

		if($stmt->num_rows == 0) {
			Header("Location: login.php?login=error");
		}
		else {
			if($dbPassword == md5($password)) {
				$_SESSION["username"] = $username;
			}
			else {
				Header("Location: login.php?login=error");
			}
		}
	}

	public function logout() {
		session_destroy();
		Header("Location: login.php");
	}

	public function authenticate() {
		if(!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
			Header("Location: login.php");
		}
	}
}
?>