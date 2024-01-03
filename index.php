<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie Projektami</title>
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
            color: grey;
			transition: background 2s ease-in-out;
        }

        .button {
            font-size: 20px;
            background-color: #201c24;
            border: 1px solid #444445;
            color: grey;
            padding: 10px 15px;
            border-radius: 10px;
            cursor: pointer;
            color: white;
        }

        .button:hover {
            outline: none;
            border: solid 1px #007BFF;
        }
		
        .cookie-container {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #444445;
            color: white;
            text-align: center;
            padding: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .cookie-btn {
            background: #007BFF;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Witaj w Systemie Zarządzania Projektami</h1>
    <p>Zaloguj się lub zarejestruj, aby rozpocząć pracę nad swoimi projektami.</p>
    
    <button class="button" onclick="window.location.href='login.php'">Rozpocznij</button>

    <div class="cookie-container" id="cookieContainer">
        Ta strona używa plików cookie. Korzystając z niej, zgadzasz się na używanie plików cookie.
        <button class="cookie-btn" onclick="acceptCookies()">Zgoda</button>
    </div>

    <script>
    
          function acceptCookies() {
			document.getElementById("cookieContainer").style.display = "none";
		}

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
			console.log(indeksTla);
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
</body>
</html>
