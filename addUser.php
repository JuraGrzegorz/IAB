	<?php
  session_start();
  $userid=$_SESSION['user_id'];
  if (!isset($userid)) {
			header("location: login.php");
			exit();
	}
	$currentUrl = $_SERVER['REQUEST_URI'];
	$urlFragments = explode('/', $currentUrl);

	$lastFragment = end($urlFragments);

	if (is_numeric($lastFragment)) {
		$projectId = intval($lastFragment);

		$currentUrl = $_SERVER['REQUEST_URI'];
		$urlFragments = explode('/', $currentUrl);

		$lastFragment = end($urlFragments);

		if (is_numeric($lastFragment)) {
			$projectId = intval($lastFragment);
		}
	}
	
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
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
		border: 1px solid #444445;
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
	
	.input-field::-webkit-calendar-picker-indicator {
		filter: invert(1);
	}
	
	.create-frame{
		text-align:center;
	}
</style>

  </head>
  <body>
	<div class="main-frame">
		<a href="/IAB/projectSettings.php/<?php echo $projectId; ?>">
            <span class="material-symbols-outlined">
			arrow_back
			</span>
		</a>
		<div class="form-frame">
			<form action="/IAB/addUser.php/<?php echo $projectId ?>" method="post">
				<h2>Dodaj użytkownika</h2>
				<label>
					Email użytwkonika
				</label>
				<input class="input-field" type="text" name="Email" required><br>
				<div class="create-frame">
					<input class="action-button" type="submit" value="Stwórz projekt">
				</div>
			</form>
		</div>
		
	</div>
	
	<?php
         
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (isset($_POST["Email"])) {
				
				$Email = $_POST["Email"];
				
				try {
					$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");

					$query = "SELECT id from users where Email=?";
					$stmt = $pdo->prepare($query);
					$stmt->execute([$Email]);
					
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($result==null){
						echo "użytkownik nie istnieje";
						return;
					}
					
					$userid=$result['id'];
					
					echo $projectId;
					$query = "SELECT * from project_users WHERE ProjectId=? AND UserId=?";
					$stmt = $pdo->prepare($query);
					$stmt->execute([$projectId,$userid]);
					
					if ($stmt->rowCount() == 0) {
						$query = "INSERT into project_users (ProjectId,UserId) VALUES (?,?)";
						$stmt = $pdo->prepare($query);
						$stmt->execute([$projectId,$userid]);
						header("location: /IAB/home.php/".$projectId); 
					} 
					
					
				} catch (PDOException $e) {
					echo "Błąd dodawania projektu: " . $e->getMessage();
				}
                
				
				
               
			}
		}
     
    ?>
	
  </body>
</html>