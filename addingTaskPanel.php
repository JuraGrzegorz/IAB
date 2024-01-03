<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (isset($_POST["projectid"])) {
				
				
				$projectid = $_POST["projectid"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "INSERT into taskstatus (Name,ProjectId) VALUES ('nowy panel',?)";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$projectid]);
			}
	}
		
?>