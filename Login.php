<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Logowania i Rejestracji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url('Data/BackGroundImage.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
			transition: background 2s ease-in-out;
        }

    

        .login-form, .register-form {
             background-color: #333333;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
			min-width:280px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
		
		.input-field{
			font-size: 16px;
			width:80%;
			color:grey;
			font-weight: bold;
			border: 1px solid grey;
			background: var(--input-background);
			&::placeholder {
				color: var(--input-placeholder);
			}
			&:focus {
				outline: none;
				border-color: var(--input-border-focus);
			}
		}
		.input-field:focus {
			outline: none;
			border-color: #007BFF;
			color:white;
		}
		
		.input-field:focus {
			outline: none;
			border-color: #007BFF;
			color:white;
		}

        .action-button {
             font-size:20px;
            background-color: #201c24;
			border: 1px solid #444445;
			color: grey;
			padding: 10px 15px;
			border-radius: 10px;
			cursor: pointer;
			color:white;
        }

        .action-button:hover {
			outline: none;
			border:solid 1px #007BFF;
        }

       

        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

       
    <div class="form-container login-form active">
        <h2>Logowanie</h2>
        <form action="/IAB/login.php" method="post">
            <input type="hidden" name="action" value="login">
            <input class="input-field" type="text" name="E_main" placeholder="E-mail" required><br>
            <input class="input-field" type="password" name="password" placeholder="Hasło" required><br>
            <input class="action-button" type="submit" value="Zaloguj">
        </form>
        <p>Nie masz jeszcze konta? <span class="switch-action">Zarejestruj się</span></p>
    </div>

    <div class="form-container register-form">
        <h2>Rejestracja</h2>
        <form action="/IAB/login.php" method="post">
            <input type="hidden" name="action" value="register">
            <input class="input-field" type="text" name="E_main" placeholder="E-main" required><br>
			<input class="input-field" type="text" name="FirstName" placeholder="First Name" required><br>
			<input class="input-field" type="text" name="LastName" placeholder="Last Name" required><br>
            <input class="input-field" type="password" name="password" placeholder="Hasło" required><br>
            <input class="input-field" type="password" name="confirm_password" placeholder="Powtórz Hasło" required><br>
            <input class="action-button" type="submit" value="Zarejestruj">
        </form>
        <p>Masz już konto? <span class="switch-action">Zaloguj się</span></p>
    </div>

    <script>
        document.querySelectorAll('.switch-action').forEach(function(element) {
            element.addEventListener('click', function() {
                document.querySelectorAll('.form-container').forEach(function(form) {
                    form.classList.toggle('active');
                });
            });
        });
		
		var tla = [
				'url(Data/BackGroundImage.jpg)',
				'url(Data/BackGroundImage2.jpg)',
				'url(Data/BackGroundImage3.jpg)'
			];
		function ustawTlo() {
			

			var body = document.body;
			var teraz = new Date();
			var sekundy = teraz.getSeconds();
			var indeksTla = (sekundy/6)%3;
			
			if(indeksTla<=1){
				body.style.backgroundImage=tla[0];
			}else{
				if(indeksTla<=2){
					body.style.backgroundImage=tla[1];
				}else{
					body.style.backgroundImage=tla[2];
				}
			}
		}

		ustawTlo();
		
		setInterval(ustawTlo, 2000);
    </script>
	<?php     
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			$host = "localhost";
			$dbname = "trello";
			$username = "root";
			$password = "";
			
			$conn = new mysqli($host, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Błąd połączenia z bazą danych: " . $conn->connect_error);
			}
			
            if($_POST["action"] == "login"){
				
				$E_main = trim(mysqli_real_escape_string($conn,$_POST["E_main"]));
				$password =	trim(mysqli_real_escape_string($conn,$_POST["password"]));
				
				$stmt = $conn->prepare("SELECT * FROM users WHERE Email=?");
				$stmt->bind_param("s",$E_main);

				if ($stmt->execute()) {
					$result = $stmt->get_result();
					$row = $result->fetch_assoc();

					if (password_verify($password, $row["Password"])) {
						$_SESSION['user_id'] = $row["Id"];
						
						$stmt = $conn->prepare("SELECT RoleId FROM users_roles WHERE UserId=?");
						$stmt->bind_param("i",$row["Id"]);
						$stmt->execute();
						$result = $stmt->get_result();
						$roleRow = $result->fetch_assoc();
						

						if ($roleRow['RoleId'] == 2) {
							echo '<script>window.location.href = "/IAB/admin.php";</script>';
						} else {
							echo '<script>window.location.href = "/IAB/home.php";</script>';
						}
					} else {
						$login_error = "Invalid password";
						echo '<div class="error-message">' . $login_error . '</div>';
					}
				}else {
					
                    $login_error = "User not found";
                     echo '<div class="error-message">' . $login_error . '</div>';
                }
            }else{
				
				$E_main = trim(htmlspecialchars($_POST["E_main"], ENT_QUOTES, 'UTF-8'));
				$FirstName = trim(htmlspecialchars($_POST["FirstName"], ENT_QUOTES, 'UTF-8'));
				$LastName = trim(htmlspecialchars($_POST["LastName"], ENT_QUOTES, 'UTF-8'));
				$password = trim(htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8'));
				$confirm_password = trim(htmlspecialchars($_POST["confirm_password"], ENT_QUOTES, 'UTF-8'));
    
                if ($password != $confirm_password) {
                    $register_error = "Passwords do not match";
                    echo '<div class="error-message">' . $register_error . '</div>';
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
                    $pdo = new PDO("mysql:host=localhost;dbname=trello", "root", "");
					$query = "SELECT * FROM users WHERE Email=?";
					$stmt = $pdo->prepare($query);
					$stmt->execute([$E_main]);

                    if ($stmt->rowCount() > 0) {
                        $register_error = "User already exists";
                        echo '<div class="error-message">' . $register_error . '</div>';
                    } else {
						
						$query = "INSERT INTO users (Email, Password,FirstName,LastName) VALUES (?, ?,?,?)";
						$stmt = $pdo->prepare($query);
						$stmt->execute([$E_main,$hashed_password,$FirstName,$LastName]);
						$lastInsertedId = $pdo->lastInsertId();
						
                        $query = "INSERT INTO users_roles (UserId,RoleId) VALUES (?,1)";
						$stmt = $pdo->prepare($query);
						$stmt->execute([$lastInsertedId]);
						
						
                    }
                }
            }
           
        }
       
    ?>
</body>
</html>