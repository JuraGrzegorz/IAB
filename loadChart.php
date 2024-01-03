<?php
	
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_GET["id"])) {
			
			$id = $_GET["id"];
			$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
			if($id==1){
				$query = "select DAY(StartDate) as Day,COUNT(*) as value from project GROUP by DAY(StartDate)";
				$stmt = $pdo->prepare($query);
				$stmt->execute([]);

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

				
				$responseData = [];

				
				foreach ($results as $result) {
					$responseData[] = [
						"Day" => $result['Day'],
						"value" =>$result['value']
					];
				}

				// Set the appropriate Content-Type header
				header('Content-Type: application/json');

				// Encode the response data as JSON and echo it
				echo json_encode($responseData);
			}
		
			if($id==2){
				$query = "select UserId as Id,COUNT(ProjectId) as Projets from project_users GROUP by (UserId) ";
				$stmt = $pdo->prepare($query);
				$stmt->execute([]);

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

				
				$responseData = [];

				
				foreach ($results as $result) {
					$responseData[] = [
						"Id" => $result['Id'],
						"Projets" =>$result['Projets']
					];
				}

				// Set the appropriate Content-Type header
				header('Content-Type: application/json');

				// Encode the response data as JSON and echo it
				echo json_encode($responseData);
			}
			
			if($id==3){
				$query = "SELECT DAY(CreationDate) as Day,Count(*) as value FROM tasks group by (DAY(CreationDate))";
				$stmt = $pdo->prepare($query);
				$stmt->execute([]);

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

				
				$responseData = [];

				
				foreach ($results as $result) {
					$responseData[] = [
						"Day" => $result['Day'],
						"value" =>$result['value']
					];
				}

				// Set the appropriate Content-Type header
				header('Content-Type: application/json');

				// Encode the response data as JSON and echo it
				echo json_encode($responseData);
			}
			
		}
	}

?>