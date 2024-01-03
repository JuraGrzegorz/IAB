<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (isset($_POST["statusid"])) {
				
				
				$statusid = $_POST["statusid"];
				$projectid= $_POST["projectid"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "insert into tasks (Title,TaskStatusId,ProjectId,CreationDate) VALUES ('Nowe Zadanie',?,?,?)";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$statusid,$projectid,date("Y-m-d H:i:s")]);
			}
	}
		
?>