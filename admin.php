<?php
  session_start();
  $userid=$_SESSION['user_id'];
  if (!isset($userid)) {
			header("location: /IAB/login.php");
			exit();
	}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel z przyciskami</title>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      display: flex;
      min-height: 100vh;
    }

    #sidebar {
      width: 200px;
      background-color: #333;
      color: #fff;
      padding: 20px;
    }

    #content {
      flex: 1;
      padding: 20px;
    }

    button {
      display: block;
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      background-color: #0077cc;
      color: #fff;
      border: none;
      cursor: pointer;
	  border-radius:10px;
    }

    button:hover {
      background-color: #005580;
    }
	.logout-frame{
		display: block;
		padding: 10px;
		margin-bottom: 10px;
		background-color: #0077cc;
		color: #fff;
		border: none;
		cursor: pointer;
		border-radius:10px;
		text-align:center;
	}
	.logout-frame:hover{
		background-color:#005580;
	}
	.project-li{
		background-color:red;
	}
	.project-ul{
		 list-style: none;
		 padding:0px;
	}
	
	.delete-button{
		cursor: pointer;
		color:white;
		border-radius:6px;
		background-color: #0077cc;
		padding:4px;
	}
	
	.delete-button:hover{
		background-color: #005580;
	}
	
	.menu{
		margin-left:auto;
		margin-right:auto;
		display: none;
	}
	
	table{
		width:100%;
		border:1px solid $color-form-highlight;
		background-color:
	}
	
	tr{
		border:1px solid black;
		
	}
	
	table td, table th {
	  border: 1px solid #ddd;
	  padding: 8px;
	  text-align:center;
	}
	
	table tr:nth-child(even){background-color: #f2f2f2;}

	table tr:hover {background-color: #ddd;}
	table th {
	  padding-top: 12px;
	  padding-bottom: 12px;
	  text-align: left;
	  background-color: #04AA6D;
	  color: white;
	}
	
	.project-name-form-field{
		display: block;
		width: 100%;
		text-align:center;
		border-radius: 3px;
		font-size:18px;
		border: 1px solid var(--input-border);
		background: var(--input-background);
		
	}
	.project-name-form-field:placeholder-shown {
	  border: 1px solid var(--input-border);
	}
	.project-name-form-field:focus {
		outline: none;
		border: none; 
	}	
  </style>
</head>
<body>

  <div id="sidebar">
    <button  onclick="changeContent(1)">Projekty</button>
    <button  onclick="changeContent(2)">Użytkownicy</button>
    <button  onclick="changeContent(3)">Zadania</button>
	
	<div class="logout-frame" onclick="logout()">
		<span>Wyloguj</span>
	</div>
  </div>

  <div id="content">
    <div class="menu">
		<div>
		<canvas id="projectsChart" width="400" height="200"></canvas>
			<table>
				<tr>
					<th>Id</th>
					<th>Nazwa</th>
					<th>Opis</th>
					<th></th>		
				</tr>
			<?php
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
				$query = "SELECT id,Name,Description from project";
				$stmt = $pdo->prepare($query);
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
				<tr>
					<td> <?php echo $row['id']; ?> </td>
					<td><input class="project-name-form-field" value="<?php echo $row['Name']; ?> " onblur="updateProjectName(this,<?php echo $row['id']; ?> )"></td>
					<td><input class="project-name-form-field" value="<?php echo $row['Description']; ?>" onblur="updateStatusName(this,<?php echo $row['id']; ?> )"></td>
					<td> <span class="delete-button" onclick="deleteProject(<?php echo $row['id']; ?>)">Usuń</span> </td>
				</tr>
			
			<?php
				}
			?>
			</table>
		</div>
	</div>
	<div class="menu">
		<div>
			<canvas id="userChart" width="400" height="200"></canvas>
			<table>
				<tr>
					<th>Id</th>
					<th>Imie</th>
					<th>Nazwisko</th>
					<th>Email</th>
					<th></th>
				</tr>
			<?php
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
				$query = "SELECT Id,FirstName,LastName,Email FROM `users`";
				$stmt = $pdo->prepare($query);
				$stmt->execute();
				

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
				<tr>
					<td> <?php echo $row['Id']; ?> </td>
					<td><input class="project-name-form-field" value=" <?php echo $row['FirstName']; ?>" onblur="updateUserName(this,<?php echo $row['Id']; ?> )"></td>
					<td><input class="project-name-form-field" value=" <?php echo $row['LastName']; ?>" onblur="updateUserLastName(this,<?php echo $row['Id']; ?> )"></td>
					<td> <input class="project-name-form-field" value="<?php echo $row['Email']; ?>" onblur="updateUserEmail(this,<?php echo $row['Id']; ?> )"></td>
					<td> <span class="delete-button" onclick="deleteUser(<?php echo $row['Email']; ?> )">Usuń</span> </td>
				</tr>
			
			<?php
				}
			?>
			</table>
		</div>
	</div>
	
	<div class="menu">
		<div>
			<canvas id="taskChart" width="400" height="200"></canvas>
			<table>
				<tr>
					<th>Id</th>
					<th>Nazwa</th>
					<th>Opis</th>
					<th>Data utworzenia</th>
					<th></th>
				</tr>
			<?php
				$pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
				$query = "SELECT Id,Title,Description,CreationDate FROM tasks";
				$stmt = $pdo->prepare($query);
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
				<tr>
					<td> <?php echo $row['Id']; ?> </td>
					<td><input class="project-name-form-field" value="<?php echo $row['Title']; ?>" onblur="updateTaskTitle(this,<?php echo $row['Id']; ?> )"> </td>
					<td><input class="project-name-form-field" value="<?php echo $row['Description']; ?>" onblur="updateTaskDescription(this,<?php echo $row['Id']; ?> )"> </td>
					<td> <?php echo $row['CreationDate']; ?>  </td>
					<td> <span class="delete-button" onclick="deleteTask(<?php echo $row['Id']; ?>)">Usuń</span> </td>
				</tr>
			
			<?php
				}
			?>
			</table>
		</div>
	</div>
  </div>
  <script>
    function changeContent(contentText) {
	  var redirectUrl = "/IAB/admin.php?id=" + contentText;
		window.location.href = redirectUrl;
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
	
	function deleteProject(id){
		$.ajax({
			type: "POST",
            url: "/IAB/updateProjectName.php",
            data: {id:id},
            success: function(response) {
                console.log(response);
	
            },
            error: function(error) {
				console.log(error);
			}
        });
	
		location.reload();
	}
	
	function deleteUser(id){
		$.ajax({
			type: "POST",
            url: "/IAB/deleteUser.php",
            data: {id:id},
            success: function(response) {
                console.log(response);
	
            },
            error: function(error) {
				console.log(error);
			}
        });
	
		location.reload();
	}
	
	function deleteTask(id){
		$.ajax({
			type: "POST",
            url: "/IAB/updatingTask.php",
            data: {id:id},
            success: function(response) {
                console.log(response);
	
            },
            error: function(error) {
				console.log(error);
			}
        });
	
		location.reload();
	}
	function loadContent() {
		var urlParams = new URLSearchParams(window.location.search);
		var id = urlParams.get('id');
		showMenu(id);
		
	}
	  $(document).ready(function () {
		loadContent();
	  });
	  
	function showMenu(number) {
		
		var allMenus = document.getElementsByClassName("menu");
		
		var selectedMenu = document.getElementsByClassName("menu")[number - 1];
		if (selectedMenu) {
		  selectedMenu.style.display="block";
		}
	}
	
	
	function fetchData() {
          $.ajax({
                type: "GET",
                url: "/IAB/loadChart.php",
                data: {id:1},
                success: function(response) {
					renderProjectsChart1(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
			
		 $.ajax({
                type: "GET",
                url: "/IAB/loadChart.php",
                data: {id:2},
                success: function(response) {
					renderProjectsChart2(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
		 $.ajax({
                type: "GET",
                url: "/IAB/loadChart.php",
                data: {id:3},
                success: function(response) {
					renderProjectsChart3(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
    }
		
	function renderProjectsChart1(data) {
		
		var ctx = document.getElementById('projectsChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line', // Change 'bar' to 'line'
			data: {
				labels: data.map(entry => entry.Day),
				datasets: [{
					label: 'Liczba projektów',
					data: data.map(entry => entry.value),
					backgroundColor: 'rgba(75, 192, 192, 0.2)',
					borderColor: 'rgba(75, 192, 192, 1)',
					borderWidth: 1,
					fill: true // Add this line to remove fill under the line
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	}
	
	function renderProjectsChart2(data) {
		
		var ctx = document.getElementById('userChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar', // Change 'bar' to 'line'
			data: {
				labels: data.map(entry => entry.Id),
				datasets: [{
					label: 'Liczba projektów',
					data: data.map(entry => entry.Projets),
					backgroundColor: 'rgba(75, 192, 192, 0.2)',
					borderColor: 'rgba(75, 192, 192, 1)',
					borderWidth: 1,
					fill: true // Add this line to remove fill under the line
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	}
	
	function renderProjectsChart3(data) {
		
		var ctx = document.getElementById('taskChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line', // Change 'bar' to 'line'
			data: {
				labels: data.map(entry => entry.Day),
				datasets: [{
					label: 'Liczba projektów',
					data: data.map(entry => entry.value),
					backgroundColor: 'rgba(75, 192, 192, 0.2)',
					borderColor: 'rgba(75, 192, 192, 1)',
					borderWidth: 1,
					fill: true // Add this line to remove fill under the line
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	}


	document.addEventListener('DOMContentLoaded', function() {
		fetchData();
	});
         

  
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
		
		function updateUserName(inputElement,id){
		
			$.ajax({
                type: "POST",
                url: "/IAB/userUpdate.php",
                data: {FirstName:inputElement.value,id:id},
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
		
		
		function updateUserLastName(inputElement,id){
			
			$.ajax({
                type: "POST",
                url: "/IAB/userUpdate.php",
                data: {LastName:inputElement.value,id:id},
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
		
		function updateUserEmail(inputElement,id){
			
			$.ajax({
                type: "POST",
                url: "/IAB/userUpdate.php",
                data: {Email:inputElement.value,id:id},
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
		
		function updateTaskTitle(inputElement,id){
			
			$.ajax({
                type: "POST",
                url: "/IAB/taskUpdate.php",
                data: {Title:inputElement.value,id:id},
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
		
		function updateTaskDescription(inputElement,id){
				
			$.ajax({
                type: "POST",
                url: "/IAB/taskUpdate.php",
                data: {Description:inputElement.value,id:id},
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
		}
  </script>
</body>
</html>