<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (isset($_POST["Title"])) {
				
				$id = $_POST["id"];
				$Title= $_POST["Title"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "UPDATE tasks SET Title=? WHERE Id=?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$Title,$id]);
			}
			
			
			if (isset($_POST["Description"])) {
				
				$id = $_POST["id"];
				$Description= $_POST["Description"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "UPDATE tasks SET Description=? WHERE Id=?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$Description,$id]);
			}
	}
		
?>