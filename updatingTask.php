<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (isset($_POST["taskstatusId"])) {
				
				
				$taskId = $_POST["taskId"];
				$taskstatusId= $_POST["taskstatusId"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "UPDATE tasks SET TaskStatusId=? WHERE Id = ?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$taskstatusId,$taskId]);
			}
			
			if (isset($_POST["title"])) {
				
				$taskid = $_POST["taskid"];
				$title= $_POST["title"];
				$desciption= $_POST["desciption"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "UPDATE tasks SET title = ?, description = ? WHERE Id = ?;";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$title,$desciption,$taskid]);
				
			}
			
			if (isset($_POST["id"])) {
				
				$id = $_POST["id"];
				
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

				$query = "DELETE from tasks WHERE id=?";
				$stmt = $pdo->prepare($query);
				$stmt->execute([$id]);
				
			}
			
	}
		
?>