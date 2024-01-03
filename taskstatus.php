<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["taskstatusid"])) {
			$taskstatusid = $_POST["taskstatusid"];
			$name=$_POST["name"];
			
			
			$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
			
			$query = "UPDATE taskstatus SET Name = ? WHERE id = ?";
			$stmt = $pdo->prepare($query);
			$stmt->execute([$name,$taskstatusid]);
			
		}
		
		if (isset($_POST["id"])) {
			$taskstatusid = $_POST["id"];
		
			$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
			
			$query = "DELETE from taskstatus WHERE id=?";
			$stmt = $pdo->prepare($query);
			$stmt->execute([$taskstatusid]);
			
		}
	}

?>