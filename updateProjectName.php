<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (isset($_POST["name"])) {
				
				
				$projectid = $_POST["projectid"];
				$name= $_POST["name"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "UPDATE project SET Name=? WHERE Id=?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$name,$projectid]);
			}
			
			if (isset($_POST["description"])) {
				
				$projectid = $_POST["projectid"];
				$description= $_POST["description"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "UPDATE project SET Description=? WHERE Id=?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$description,$projectid]);
			}
			
			
			if (isset($_POST["id"])) {
				
				$projectid = $_POST["id"];
				
				
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "DELETE FROM project_users WHERE ProjectId = ?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$projectid]);
				
				
				$query = "DELETE FROM tasks WHERE ProjectId = ?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$projectid]);
				
				$query = "DELETE FROM taskstatus WHERE ProjectId = ?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$projectid]);
				

				$query = "DELETE FROM project WHERE id = ?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$projectid]);
			}
			
	}
		
?>