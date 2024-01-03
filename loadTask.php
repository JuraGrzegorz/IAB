<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if (isset($_POST["taskId"])) {
			$taskId = $_POST["taskId"];
					
			$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

			$query = "SELECT Title, Description, UserId FROM `tasks` WHERE id=?";
			$stmt = $pdo->prepare($query);
			$stmt->execute([$taskId]);

			// Pobieranie wyników z zapytania
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			// Tworzenie tablicy z danymi do zwrócenia
			$responseData = [
				"Title" => $result["Title"],
				"Description" => $result["Description"],
				"UserId" => $result["UserId"]
			];

			header('Content-Type: application/json');
			echo json_encode($responseData);
		}
		
		if (isset($_POST["UserId"])) {
			$UserId = $_POST["UserId"];
					
			$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

			$query = "SELECT FirstName,LastName FROM users WHERE Id=?";
			$stmt = $pdo->prepare($query);
			$stmt->execute([$UserId]);

			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$responseData = [
				"FirstName" => $result["FirstName"],
				"LastName" => $result["LastName"],
			];

			header('Content-Type: application/json');
			echo json_encode($responseData);
		}
		
		if (isset($_POST["Id"])) {
	 
			$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

			$query = "Update tasks SET UserId=? where Id=?";
			$stmt = $pdo->prepare($query);
			$stmt->execute([$_POST["Id"],$_POST["Task"]]);
			
			
		}
	}

?>