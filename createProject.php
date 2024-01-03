<?php
  session_start();
  $userid=$_SESSION['user_id'];
  if (!isset($userid)) {
			header("location: /IAB/login.php");
			exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
      
    />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>

		* {
		  margin: 0;
		  padding: 0;
		  box-sizing: border-box;
		  font-family: "Poppins", sans-serif;
		}
		body {
		  min-height: 100%;
		  background: #201c24;
		}
		
		.material-symbols-outlined {
		  color:grey;
		  font-size:30px;
		  
		  font-variation-settings:
		  'FILL' 0,
		  'wght' 200,
		  'GRAD' 200,
		  'opsz' 48
		}
		.material-symbols-outlined:hover {
		  background-color:#21130d;
		  border-radius:10px;
		  
		}
		.main-frame{
			height:100vh;
			width:100%;
			padding:15px;
		}
		
		form {
			position: relative;
			top: 40vh;
			transform: translateY(-50%);
			max-width: 400px;
			margin: 0 auto;
			padding: 20px;
			border: 1px solid #444445;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			color:grey;
		}

		h2 {
			color: white;
			font-size:35px;
			margin:10px;
			margin-bottom:20px;
		}

	label {
		display: block;
		margin-bottom: 8px;
		font-size:15px;
	}

	.input-field {
		width: 100%;
		padding: 10px;
		margin-bottom: 15px;
		box-sizing: border-box;
		border: 1px solid #black;
		border-radius: 4px;
		background-color: transparent;
		color:white;
	}

	.input-field:focus {
		outline: none;
		border-color: #007BFF;
	}

	.action-button {
		background-color: #201c24;
		border: 1px solid #444445;
		color: grey;
		padding: 10px 15px;
		border-radius: 4px;
		cursor: pointer;
	}

	.action-button:hover {
		background-color: #007BFF;
		color:white;
	}
	.action-button-frame{
		text-align:center;
	}
	.input-field::-webkit-calendar-picker-indicator {
		filter: invert(1);
	}
	
</style>
    </style>
  </head>
  <body>
	<div class="main-frame">
		<a href="home.php">
            <span class="material-symbols-outlined">
			arrow_back
			</span>
		</a>
		<div class="form-frame">
			<form action="createProject.php" method="post">
				<h2>Nowy projekt</h2>
				<label>
					Nazwa projektu
				</label>
				<input class="input-field" type="text" name="ProjectName" required><br>
				<label>
					Opis projektu
				</label>
				<input class="input-field" type="text" name="ProjectDescription"><br>
				<label>
					Przewidywana data zakończenia
				</label>
				<input class="input-field" type="date" name="ProjectEnaDate"><br>
				<div class="action-button-frame">
				<input class="action-button" type="submit" value="Stwórz projekt">
				<div>
			</form>
		</div>
		
	</div>
	
	<?php
         
        
		
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (isset($_POST["ProjectName"])) {
				
				$projectName = $_POST["ProjectName"];
				$projectDescription = isset($_POST["ProjectDescription"]) ? $_POST["ProjectDescription"] : "";
				$projectEndDate = isset($_POST["ProjectEnaDate"]) ? $_POST["ProjectEnaDate"] : "";
				
				try {
					$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

					$query = "INSERT INTO project (Name,Description,StartDate,EndDate) VALUES (?, ?, ?,?)";
					$stmt = $pdo->prepare($query);
					$stmt->execute([$projectName, $projectDescription,date("Y-m-d H:i:s"),$projectEndDate]);
					
					$ProjecttId = $pdo->lastInsertId();
					
					$query = "insert into project_users (ProjectId,UserId) VALUES (?,?)";
					$stmt = $pdo->prepare($query);
					$stmt->execute([$ProjecttId,$userid]);
					
					$query = "INSERT into taskstatus (Name,ProjectId) VALUES ('Do zrobienia',?)";
					$stmt = $pdo->prepare($query);
					$stmt->execute([$ProjecttId]);
					
					$query = "INSERT into taskstatus (Name,ProjectId) VALUES ('W toku',?)";
					$stmt = $pdo->prepare($query);
					$stmt->execute([$ProjecttId]);
					
					$query = "INSERT into taskstatus (Name,ProjectId) VALUES ('Zrobione',?)";
					$stmt = $pdo->prepare($query);
					$stmt->execute([$ProjecttId]);
					
					
				} catch (PDOException $e) {
					echo "Błąd dodawania projektu: " . $e->getMessage();
				}
                
				
				
                header("location: home.php"); 
			}
		}
     
    ?>
	
  </body>
</html>