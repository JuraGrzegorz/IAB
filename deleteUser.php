<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (isset($_POST["id"])) {
				
				$id = $_POST["id"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "DELETE from users_roles WHERE UserId=?";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$id]);
				
				$query = "DELETE from users WHERE id=?";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$id]);
				
			}
			
	}
		
?>