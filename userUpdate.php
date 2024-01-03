<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (isset($_POST["FirstName"])) {
				
				$id = $_POST["id"];
				$FirstName= $_POST["FirstName"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "UPDATE users SET FirstName=? WHERE Id=?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$FirstName,$id]);
			}
			
			if (isset($_POST["LastName"])) {
				
				$id = $_POST["id"];
				$LastName= $_POST["LastName"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "UPDATE users SET LastName=? WHERE Id=?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$LastName,$id]);
			}
			
			if (isset($_POST["Email"])) {
				
				$id = $_POST["id"];
				$Email= $_POST["Email"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "UPDATE users SET Email=? WHERE Id=?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$Email,$id]);
			}
	}
		
?>