<?php
  session_start();
  $userid=$_SESSION['user_id'];
  if (!isset($userid)) {
		header("location: /IAB/login.php");
		exit();
	}
	$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
	$query = "SELECT project.Id,project.Name FROM project_users
		inner join users on users.Id=project_users.UserId
		inner join project on project.id=project_users.ProjectId where users.Id=?";
	$stmt = $pdo->prepare($query);
	$stmt->execute([$userid]);
	
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
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

		header {
		  position: fixed;
		  top: 0;
		  left: 0;
		  height: 6vh;
		  width: 100%;
		  display: flex;
		  align-items: center;
		  background: #302c34;
		  box-shadow: 0 0 1px rgba(0, 0, 0, 0.1);
		  border-bottom:solid 1px #444445
		}
		header .logo {
		  display: flex;
		  align-items: center;
		  margin: 0 24px;
		}
		
		.logo .menu-icon {
		  color: white;
		  font-size: 24px;
		  margin-right: 14px;
		  cursor: pointer;
		  padding:3px;
		}
		.logo .menu-icon:hover {
			background-color:#201c24;
			border-radius:10px;
			padding:3px;
		}
		.logo .logo-name {
		  color: #333;
		  font-size: 22px;
		  font-weight: 500;
		}
		
		nav .sidebar {
		  position: fixed;
		  top: 6vh;
		  left: -15%;
		  height: 94vh;
		  width: 15%;
		  min-width: 150px;
		  background: #302c34;
		  box-shadow: 0 5px 1px rgba(0, 0, 0, 0.1);
		  transition: all 0.4s ease;
		  z-index:2;
		}
		nav.open .sidebar {
		  left: 0;
		}
		
		.sidebar .sidebar-content {
		  display: flex;
		  height: 94vh;
		  flex-direction: column;
		  padding: 30px 16px;
		}
		.sidebar-content .list {
		  list-style: none;
		  
		}
		.list .nav-link {
		  display: flex;
		  align-items: center;
		  margin: 8px 0;
		  padding: 14px 12px;
		  border-radius: 8px;
		  text-decoration: none;
		}
		.lists .nav-link:hover {
		  outline: none;
			border:solid 1px #007BFF;
			
		}
		
		.nav-link .link {
		  font-size: 16px;
		  color: white;
		  font-weight: 400;
		}
		.link{
			text-align:center;
		}
		.lists .nav-link:hover .link {
		  color: #fff;
		}
			
		.main-frame-button{
			font-size:18px;
			margin-left:auto;
			margin-right:auto;
			color:white;
			text-decoration:none;
			border-bottom:solid 1px #444445;
			padding:10px;
		}
		
		.button-start{
		  border-radius: 50px;
		  background:#403c44;
		  width: 100px;
		  height:30px;
		  color:white;
		  font-size: 19px;  
		  
		}
		.button-start-create{
		  float:left;
		  font-size:16px;
		  padding-top:5px;
		  padding-left:5px;
		}
		.button-start-circle{
		  float:left;
		  background-color:red;
		  width:20px;
		  height: 20px;
		  margin:6px;
		  border-radius: 50%;
		  align-items:center;
		  
		}

		.button-start:hover{
			background-color:#007BFF;
			cursor: pointer;
		}
		.material-symbols-outlined {
		  font-size: 20px;
		}

		
		
		
		
		.button:hover{
		  background:#000;
		  color:white;
		  cursor: pointer;
		}
		.create-task{
		  position:fixed;
		  width:40%;
		  height:86vh;
		  top:13vh;
		  right:0%;
		  margin-right:10px;
		  background-color:#302c34;
		  border:solid 1px #444445;
		  float:right;
		  border-radius: 15px;
		  visibility:hidden;
		  z-index:2;
		}
		.create-task-header{
		  width:100%;
		  height:8%;
		  border-bottom:solid 1px #444445;
		} 
		 .create-task-header-title{
			float:left;
			padding:8px;
			width:85%;
		}
		 
		.task-name-form-field{
		  display: block;
			width: 100%;
			padding: 8px 16px;
			line-height: 25px;
			font-size: 22px;
			font-weight: 500;
			font-family: inherit;
			border-radius: 6px;
			-webkit-appearance: none;
			color: grey;
			font-size:20px;
			font-weight: bold;
			border: 1px solid var(--input-border);
			background: var(--input-background);
			&::placeholder {
				color: var(--input-placeholder);
			}
			&:focus {
				outline: none;
				border-color: var(--input-border-focus);
			}
		}
		
		.task-name-form-field:not(:placeholder-shown) {
		  color: white;
		}
		.create-task-header-title-text{
		  font-size:16px;
		  color:grey;
		}
		.create-task-close{
		  float:right;
		  font-size:25px;
		  padding:8px;
		}
		
		.create-task-close .material-symbols-outlined {
		  font-size: 30px;
		  color:grey;
		  font-variation-settings:
		  'FILL' 0,
		  'wght' 200,
		  'GRAD' 0,
		  'opsz' 24
		}
		.create-task-close .material-symbols-outlined:hover{
			background-color:#201c24;
			border-radius:10px;
			cursor: pointer;
		}
		
		
		.main-frame{
			width: 100%;
			height: 94vh;
			position: fixed;
			top:6vh;
			z-index: 1;
			transition: all 0.4s ease;
		}
		
		main.open .main-frame {
			margin-left: 15%;
		}
		
		
		.main-frame-header{
			width:100%;
			min-height:6vh;
			padding:15px;
			border-bottom:solid 1px #444445
		}
		.main-frame-header-projectname{
			color:white;
		}
		
		.main-frame-main{
			width:100%;
			height:88vh;
			display: flex;
			overflow-x: auto;
		}
		
		.main-frame-moveblock{
			width:100%;
			height:20%;
			border-radius:15px;
			padding:10px;
			margin-bottom:10px;
			border:solid 1px grey;
			color:white
		}
		
		.main-frame-moveblock:hover{
			
			border:solid 1px white;
		}
		
		.dragging {
		  opacity: 0.5;
		  
		  
		}
		
		.main-frame-join{
			float:right;
			font-size:16px;
			border-radius: 8px;
			padding:2px;
			border: 1px solid #444445;
		}
		.main-frame-join:hover{
			border-color: #007BFF;
		}
		
		.add-peaoplebutton{
			Color:white;
			text-decoration: none;
			
		}
		
		
		
		.main-frame-col{
			height:95%;
			width:22%;
			min-width:200px;
			margin-left:5px;
			padding:5px;
			border-radius:10px;
			margin:10px;
		}
		
		.main-frame-col:hover{
			border:1px solid grey;
		}
		
		
		
		.section-add-section{
			height:95%;
			width:22%;
			min-width:200px;
			margin-left:5px;
			padding:5px;
			border-radius:10px;
			margin:10px;
		}
		
		
		.section-fild-name{
			padding:10px;
		}
		
		.section-fild-title{
			font-size: 16px;
			width:80%;
			color:white;
			font-weight: bold;
			border: 1px solid var(--input-border);
			background: var(--input-background);
			&::placeholder {
				color: var(--input-placeholder);
			}
			&:focus {
				outline: none;
				border-color: var(--input-border-focus);
			}
		}
		.section-fild-title:not(:placeholder-shown) {
		  color: white;
		}
		
		.section-fild-name .material-symbols-outlined{
			font-size:20px;
			float:right;
			color:white;
		  font-variation-settings:
		  'FILL' 0,
		  'wght' 400,
		  'GRAD' 0,
		  'opsz' 24
		}

		.section-fild-name .material-symbols-outlined:hover{
			background-color:black;
			border-radius:5px;
			cursor: pointer;
		}
		
		.add-task-button{
			width:100%;
			background-color: transparent;
			border: none;
			cursor: pointer;
			color:grey;
			font-size:16px;
			padding:10px;
			border-radius:10px;
		}
		.add-task-button:hover{
			background-color:#302c34 ;
			color:white;
			
		}
		
		.create-task-desciption{
			width:100%;
			padding:10px;
			
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
			border: 1px solid #444445;
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
			resize: none
		}
		
		.description-name-form-field:focus{
			border: 1px solid grey;	
		}
		.description-name-form-field:not(:placeholder-shown) {
		  color: white;
		}
		
		
		.project-name-form-field{
			font-size: 16px;
			width:80%;
			color:white;
			font-weight: bold;
			border: 1px solid var(--input-border);
			background: var(--input-background);
			&::placeholder {
				color: var(--input-placeholder);
			}
			&:focus {
				outline: none;
				border-color: var(--input-border-focus);
			}
		}
		
		.header-title-page{
			width:100%;
			height:8vh;
			padding:22px;
			color:white;
			font-size:20px;			
		}
		
		.main-title-page{
			width:100%;
			height:20vh;
			color:white;
		}
		
		.main-title-page-span{
			display: table;
			font-size:20px;
			margin: 0 auto;
			padding:4px;		
		}
		.main-hellow-page-span{
			font-size:34px;
			display: table;
			margin: 0 auto;
			
		}
		.task-id-class{
			
			display: none;
		}
		.logout-frame{
			width:100%;
			margin-top: auto;
			padding: 10px;
			font-size: 16px;
			color: #fff;
			border: solid 1px #444445;
			border-radius:10px;
			cursor: pointer;
			text-align:center;
		}
		.logout-frame:hover{
			border: solid 1px #007BFF;
		}
		
		.task-title{
			font-size:20px;
		}
		
		.task-CreationDate{
			float:right;
			color:grey;
			
		}
		.task-description{
			display: inline-block;
			font-size:14px;
			max-width: 100%; /* Zapobiega przekraczaniu szerokości kontenera przez textarea */
			max-height: 65px;
			resize: vertical; /* Umożliwia tylko pionową zmianę rozmiaru textarea */
			overflow-y: auto; /* Dodaje pionowe paski przewijania, jeśli tekst nie mieści się w oknie textarea */
			word-wrap: break-word;
			resize:none;
		}
		
		.main-frame-main-section{
			height:95%;
			max-height:95%;
			overflow-y: auto;
		}
		.lists{
		  color:white;
		  overflow-y: auto;
		}
		.taks-title-frame{
			overflow: hidden; 
			display: inline-block; 
			max-width: 100%; 
			white-space: nowrap;
			text-overflow: ellipsis; 
		}
		.task-desciption-frame{
			width:100%;
			height:65px;
		}
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
  }
 ::-webkit-scrollbar-track {
    border-radius: 10px;
    background: rgba(0,0,0,0.1);
  }
 ::-webkit-scrollbar-thumb{
    border-radius: 10px;
    background:grey;
  }
::-webkit-scrollbar-thumb:hover{
  	background: rgba(0,0,0,0.4);
  }
::-webkit-scrollbar-thumb:active{
  	background: rgba(0,0,0,.9);
  }

.delete-project-button{
	background-color: #201c24;
	border: 1px solid red;
	color: white;
	padding: 10px;
	
	border-radius: 4px;
	cursor: pointer;
	float:right;
	width:100px;
	text-align:center;
	font-size:14px;
}
.delete-project-button:hover{
	color:white;
		border-color:#007BFF;
}
.save-button{
	background-color: #201c24;
		border: 1px solid #444445;
		color: white;
		font-size:14px;
		padding: 10px;
		border-radius: 4px;
		cursor: pointer;
		float:left;
		width:100px;
		text-align:center;
}
.save-button:hover{
	border: 1px solid #007BFF;
}
.buttons-frame{
	width:60%;
	height:50px;
	margin-left:auto;
	margin-right:auto;
	
}

	@media only screen and (max-width: 1000px) {
			  main.open .main-frame{
				  margin-left:150px;
			  }
			  nav .sidebar {
				  left: -150px;
				}
			.create-task{
				  width:60%;
			  }
		}
		@media only screen and (max-width: 700px) {
		  .create-task{
			  width:95%;
		  }
		  .project-name-form-field{
			  width:60%;
		  }
		}
		
		.asign-user{
			height:60px;
			margin:10px;
		}
		
		.asingUserId{
			color:white;
			font-size:20px;
			padding:5px;
			
		}
		.asing-user-header{
			color:grey;
		}
		.asign-button{
			float:right;
			margin:20px;
			background-color: #201c24;
			border: 1px solid #444445;
			color: white;
			font-size:14px;
			border-radius: 4px;
			cursor: pointer;
			width:100px;
			height:40px;
			text-align:center;
		}
		.asign-button:hover{
			border: 1px solid #007BFF;
		}
    </style>
  </head>
  <body>
    <header>
    <div class="logo">
        <i class="bx bx-menu menu-icon" ></i>
        <a class="button-start" id="button-start" href="/IAB/createProject.php">
          <div class="button-start-circle">
              <span class="material-symbols-outlined">
                add
              </span>
          </div>
          
          <span class="button-start-create" >Utwórz</span>
        </a>
      </div>
    </header>
    <nav>
      <div class="sidebar">
         <div class="sidebar-content">
		  <a href="/IAB/home.php" class="main-frame-button">Strona główna</a>
          <ul class="lists">
			<?php foreach ($result as $row){ ?>
			<li class="list">
				<a href="/IAB/home.php/<?php echo $row['Id']; ?>" class="nav-link">
					<span class="link"><?php echo $row['Name']; ?></span>
				</a>
			</li>
			
			<?php }?>
          </ul>
		  <div class="logout-frame" onclick="logout()">
				<span>Wyloguj</span>
		  </div>
        </div>
      </div>
    </nav>
    <main>
		<div class="main-frame">
		
		<?php
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
				?>
				<div class="main-frame-header">
				<span class="main-frame-header-projectname">
				<?php
					try {
						$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
						$query = "SELECT Name FROM project WHERE id=?";
						$stmt = $pdo->prepare($query);
						$stmt->execute([$projectId]);
						$result = $stmt->fetch(PDO::FETCH_ASSOC);
				
					} catch (PDOException $e) {
						echo "Błąd zapytania SELECT: " . $e->getMessage();
					}
				?>
				
					<input class="project-name-form-field" value="<?php echo $result['Name']; ?>" onblur="updateProjectName(this,<?php echo $projectId; ?>)">
					
				</span>
				<div class="main-frame-join">					
					<a href="/IAB/projectSettings.php/<?php echo $projectId; ?>" class="add-peaoplebutton">
						<span>Zarządzaj</span>
					</a>	
						
					</div>
				</div>
				
				
				<div class="main-frame-main">
					
					<?php 
					

						$query = "SELECT id,Name FROM taskstatus WHERE ProjectId=?";
						$stmt = $pdo->prepare($query);
						$stmt->execute([$projectId]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						
					foreach ($result as $row){?>
						<?php
							$taskstatusId = $row['id'];
							$statusname=$row['Name'];
						?>
					<div class="main-frame-col">
						
						<div class="main-frame-section-fild">
								<div class="section-fild-name">
									<input class="section-fild-title" value="<?php echo $statusname; ?>" onblur="updateStatusName(this,<?php echo $taskstatusId; ?>)">
									<span class="material-symbols-outlined" onclick="deleteStatusPanel(<?php echo $taskstatusId; ?>)">
										delete
									</span>
								</div>
						</div>
						<div class="main-frame-main-section" data-taskstatus-id="<?php echo $taskstatusId; ?>">
							<?php
								
								$query = "SELECT Id, Title,Description,CreationDate FROM `tasks` WHERE TaskStatusId=?";
								$stmt = $pdo->prepare($query);
								$stmt->execute([$taskstatusId]);
								$result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
								
								foreach ($result2 as $row2) {
									
									$taskDataId = $row2['Id'];
									?>
									<div class="main-frame-moveblock"  draggable="true" data-task-id="<?php echo $taskDataId; ?>">
										<div class="taks-title-frame">
											<span class="task-title">
												<?php echo $row2['Title']; ?>
											</span>
										</div>
											
										<div class="task-desciption-frame">
											<span class="task-description">
												<?php echo $row2['Description']; ?>
											</span>
										</div>
										<span class="task-CreationDate">
												<?php echo $row2['CreationDate']; ?>
										</span>
									</div>
								<?php } ?>
								
								
								<button id="myButton" class="add-task-button" onclick="createTask('<?php echo $taskstatusId ?>','<?php echo $projectId ?>')">Dodaj zadanie</button>
									
						</div>
					</div>
					<?php } ?>
					<div  class="section-add-section">
						<div>
							<button  class="add-task-button" onclick="createStatusPanel('<?php echo $projectId ?>')">Dodaj sekcję</button>
						</div>
					</div>
				</div>
			</div>
				
				
		<?php
			}
				
			}else{
				?>
				
				<div class="header-title-page">
					<span > Strona główna </span>
				
				</div>
				<div class="main-title-page">
					<span class="main-title-page-span"> 
						<?php
							setlocale(LC_TIME, 'polish_poland.utf8'); // Ustawienie lokalizacji na polską

							$currentDate = strftime('%A, %e %B'); // Formatowanie daty

							echo $currentDate;
							
						?>
					</span>
					<span class="main-hellow-page-span"> 
						Dzień dobry, 
						<?php
							$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
							$query = "SELECT FirstName,LastName from users WHERE id=?";
							$stmt = $pdo->prepare($query);
							$stmt->execute([$userid]);
							$result = $stmt->fetch(PDO::FETCH_ASSOC);
							echo $result['FirstName'].' '.$result['LastName'];
						?>
					</span>
				</div>
				
				<?php
			}
			
		?>
		
		
    </main>
	<div class="create-task" id="create-task">
		
          <div class="create-task-header">
              <div class="create-task-header-title">
				
                <input class="task-name-form-field" name="title" placeholder="Wprowadz nazwe zadania" >
              </div>
              <div class="create-task-close">
                <span class="material-symbols-outlined" id="createTaskClose">
                  close
                </span>
				
              </div>
           </div>
          <div class="create-task-main">
            <div class="create-task-desciption">
				<textarea class="description-name-form-field" name="description" placeholder="Wprowadz opis zadania"></textarea>
            </div>
          </div>
		  <input class="task-id-class" name="taskid" >
		  
		<div class="asign-user">
			<span class="asing-user-header">Przypisany użytkownik</span>
			<input class="asign-button" type="submit" value="dopisz się" onclick="asignToTask()"><br>
			<span class="asingUserId"></span>
		</div>
		<div class="buttons-frame">
			<input class="save-button" type="submit" value="zapisz" onclick="updateTask()">
			<input class="delete-project-button" type="submit" value="usuń" onclick="deleteTask()">
		</div>
    </div>
    
      
    <script>
		
        const navBar = document.querySelector("nav"),
       menuBtns = document.querySelectorAll(".menu-icon");
	    main = document.querySelector("main");
     menuBtns.forEach((menuBtn) => {
       menuBtn.addEventListener("click", () => {
         navBar.classList.toggle("open");
		 main.classList.toggle("open");
       });
     });
       
        
        
    

      const crTask = document.getElementById("create-task");
      const crTaskClose = document.getElementById("createTaskClose");
   
       crTaskClose.addEventListener("click", () => {
          crTask.style.visibility="hidden";
       });
	
		const tasks = document.querySelectorAll(".main-frame-moveblock");

		tasks.forEach((task) => {
		  task.addEventListener("click", () => {
			const taskId = task.getAttribute("data-task-id");
			console.log(taskId);
			
			$.ajax({
                type: "POST",
                url: "/IAB/loadTask.php",
                data: {taskId:taskId},
                success: function(response) {
			
					const Title = response.Title;
					const Description = response.Description;
					const UserId = response.UserId;
					
					const taskNameField = document.querySelector(".task-name-form-field");
					const desciptionNameField = document.querySelector(".description-name-form-field");
					const taskid = document.querySelector(".task-id-class");
					const asingUserId=document.querySelector(".asingUserId");
					taskNameField.value = Title;
					desciptionNameField.value=Description;
					taskid.value=taskId;
					
					const asignButton=document.querySelector(".asign-button");
					if(UserId==null){
						asingUserId.innerText="";
						asignButton.style.visibility='visible';
					}else{
						asignButton.style.visibility='hidden';
						$.ajax({
							type: "POST",
							url: "/IAB/loadTask.php",
							data: {UserId:UserId},
							success: function(response) {
								console.log(response)
								asingUserId.innerText =response.FirstName + response.LastName;
							},
							error: function(error) {
								console.log(error);
							}
							
						});
						
					}
					
                },
                error: function(error) {
                    console.log(error);
                }
            });
			
			crTask.style.visibility="visible";
		  });
		});
		
		
		function updateTask(){
			const taskNameField = document.querySelector(".task-name-form-field");
			const desciptionNameField = document.querySelector(".description-name-form-field");
			const taskid = document.querySelector(".task-id-class");
					
			$.ajax({
                type: "POST",
                url: "/IAB/updatingTask.php",
                data: {taskid:taskid.value,title:taskNameField.value,desciption:desciptionNameField.value},
                success: function(response) {
                    console.log(response);
					location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
			
		}

		
		const columns = document.querySelectorAll(".main-frame-main-section");
	
		document.addEventListener("dragstart", (e) => {
		  e.target.classList.add("dragging");
		});

		document.addEventListener("dragend", (e) => {
		  e.target.classList.remove("dragging");
		});
		
	
		
		let val = 0; 
		let firstDragOver = true; 

		columns.forEach((item, index) => {
		  item.addEventListener("dragover", (e) => {
			const dragging = document.querySelector(".dragging");
			const applyAfter = getNewPosition(item, e.clientY);

			if (applyAfter) {
			  applyAfter.insertAdjacentElement("afterend", dragging);
			} else {
			  item.prepend(dragging);
			}

			const taskstatusId = item.getAttribute("data-taskstatus-id");
			const taskId = dragging.getAttribute("data-task-id");

			if (val != taskstatusId) {
				if(!firstDragOver){
					$.ajax({
					type: "POST",
					url: "/IAB/updatingTask.php",
					data: { taskId: taskId,taskstatusId:taskstatusId},
					success: function(response) {
						console.log(response);
					},
					error: function(error) {
						console.log(error);
					}
				});
				}
			  val = taskstatusId;
			}

			firstDragOver = false; // ustawiamy na false po pierwszym zdarzeniu "dragover"
		  });
		});

		function getNewPosition(column, posY) {
		  const cards = column.querySelectorAll(".main-frame-moveblock:not(.dragging)");
		  let result;
			
		  for (let refer_card of cards) {
			const box = refer_card.getBoundingClientRect();
			const boxCenterY = box.y + box.height / 2;

			if (posY >= boxCenterY) result = refer_card;
			
			
		  }
		  return result;
		}
		
		const openTask = document.getElementById("main-frame-moveblock");
		const asd = document.getElementById("create-task");
        openTask.addEventListener("click", () => {
          crTask.style.visibility="visible";
       });
       crTaskClose.addEventListener("click", () => {
          crTask.style.visibility="hidden";
       });
	   
	   
	    function createTask(statusid,projectid) {
           
			$.ajax({
                type: "POST",
                url: "/IAB/createNewTask.php",
                data: { statusid: statusid,projectid:projectid},
                success: function(response) {
                    console.log(response);
					location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
			
        }
		function createStatusPanel(projectid) {
           
			$.ajax({
                type: "POST",
                url: "/IAB/addingTaskPanel.php",
                data: {projectid:projectid},
                success: function(response) {
                    console.log(response);
					location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
			
        }
		
		
		function updateStatusName(inputElement,taskstatusid) {
			$.ajax({
                type: "POST",
                url: "/IAB/taskstatus.php",
                data: {name:inputElement.value,taskstatusid:taskstatusid},
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
		
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
		
		function deleteStatusPanel(id){
			$.ajax({
                type: "POST",
                url: "/IAB/taskstatus.php",
                data: {id:id},
                success: function(response) {
                    console.log(response);
					location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
			
		}
		function logout(){
			$.ajax({
                type: "POST",
                url: "/IAB/logout.php",
                
                success: function(response) {
                    console.log(response);
	
                },
                error: function(error) {
                    console.log(error);
                }
            });
			
			window.location.href = "/IAB/login.php";
		}
		function deleteTask(){
			const taskid = document.querySelector(".task-id-class");
				
			$.ajax({
                type: "POST",
                url: "/IAB/updatingTask.php",
                data: {id:taskid.value},
                success: function(response) {
                    console.log(response);
					location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
		
		function asignToTask(){
			const TaskId=document.querySelector(".task-id-class");
			
			$.ajax({
                type: "POST",
                url: "/IAB/loadTask.php",
                data: {Task:TaskId.value,Id: <?php echo  $userid ?>},
                success: function(response) {
                    console.log(response);
					location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
    </script>
	
   
  </body>
</html>