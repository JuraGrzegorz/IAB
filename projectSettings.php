<?php
  session_start();
  $userid=$_SESSION['user_id'];
  if (!isset($userid)) {
			header("location: /IAB/login.php");
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
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
		
		.main {
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
		margin: 8px;
		margin-left:0px;
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
		border: 1px solid red;
		color: white;
		padding: 10px;
		border-radius: 4px;
		cursor: pointer;
		float:right;
		width:150px;
		text-align:center;
		font-size:14px;
	}

	.action-button:hover {
		color:white;
		border-color:#007BFF;
	}
	
	
	.action-button-a{
		background-color: #201c24;
		border: 1px solid #444445;
		color: white;
		font-size:14px;
		padding: 10px;
		border-radius: 4px;
		cursor: pointer;
		float:left;
		width:150px;
		text-align:center;
	}
	
	.action-button-a:hover{
		border: 1px solid #007BFF;
	}
	
	.buttons-field{
		width:100%;
		height:40px;
	}
	
	.input-field::-webkit-calendar-picker-indicator {
		filter: invert(1);
	}
	
	.create-frame{
		text-align:center;
	}
	
	
		
	.project-name-form-field{
		display: block;
		width: 100%;
		padding: 8px 16px;
		line-height: 25px;
		font-weight: 500;
		font-family: inherit;
		border-radius: 6px;
		-webkit-appearance: none;
		color:white;
		font-size:20px;
		font-weight: bold;
		border: 1px solid var(--input-border);
		background: var(--input-background);
		border:1px solid #444445;
	}
	.project-name-form-field:placeholder-shown {
	  color: var(--input-placeholder);
	}
	
	.description-name-form-field{
		display: block;
		width: 100%;
		height:25vh;
		padding: 8px 16px;
		line-height: 25px;
		font-weight: 500;
		font-family: inherit;
		border-radius: 6px;
		-webkit-appearance: none;
		color: grey;
		font-size:16px;
		border: 1px solid var(--input-border);
		background: var(--input-background);
		word-wrap: break-word;
		hite-space: pre-wrap;
		&::placeholder {
			color: var(--input-placeholder);
		}
		&:focus {
			outline: none;
			border-color: var(--input-border-focus);
		}
		resize: none;
		border: 1px solid grey;	
	}
		
	.description-name-form-field:not(:placeholder-shown) {
	  color: white;
	}	
	
	
</style>

  </head>	
  <body>
	<div class="main-frame">
		<a href="/IAB/home.php/<?php echo $projectId; ?>">
            <span class="material-symbols-outlined">
			arrow_back
			</span>
		</a>
		<div class="form-frame">
			<?php
					try {
						$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
						$query = "SELECT * FROM project WHERE id=?";
						$stmt = $pdo->prepare($query);
						$stmt->execute([$projectId]);
						$result = $stmt->fetch(PDO::FETCH_ASSOC);
				
					} catch (PDOException $e) {
						echo "Błąd zapytania SELECT: " . $e->getMessage();
					}
			?>
			<div class="main">
				<label>
					Nazwa projektu
				</label>
				<input class="project-name-form-field" value="<?php echo $result['Name']; ?>" onblur="updateProjectName(this,<?php echo $projectId; ?>)">
				<label>
					Opis
				</label>
				
				<textarea class="description-name-form-field" placeholder="Wprowadz opis" onblur="updateStatusName(this,<?php echo $projectId; ?>)"><?php echo $result['Description']; ?></textarea><br>
				
				<div class="buttons-field">
				
				<a href="/IAB/addUser.php/<?php echo $projectId ?>">
					<span class="action-button-a" value="Dodaj użytkowników">Dodaj użytkowników</span>
				</a>
				
				
				<span class="action-button" onclick="deleteProject(<?php echo $projectId; ?>)">Usuń projekt</span>
				</div>
				
				
				
			</div>
			
		</div>
		
	</div>
	
	<?php
         
        
        
     
    ?>
	<script>
		function updateProjectName(inputElement,projectid) {
			$.ajax({
                type: "POST",
                url: "/IAB/updateProjectName.php",
                data: {name:inputElement.value,projectid:projectid},
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
		
		function updateStatusName(inputElement,projectid){
			$.ajax({
                type: "POST",
                url: "/IAB/updateProjectName.php",
                data: {description:inputElement.value,projectid:projectid},
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
		function deleteProject(projectid){
			$.ajax({
                type: "POST",
                url: "/IAB/updateProjectName.php",
                data: {id:projectid},
                success: function(response) {
                    console.log(response);
					window.location.href = "/IAB/home.php";
                },
                error: function(error) {
                    console.log(error);
                }
            });
			
		}
		
	</script>
  </body>
</html>