<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: gra.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Polanka - Zarządzaj swoim domem jak nigdy dotąd</title>
</head>

<body>

    "Only the stupid need organization,the genius controls the chaos!" - Albert Einstein
    <br  /><br/>


    

    <form action="zaloguj.php" method="post">

        Mail: <br/><input type="text" name="mail"><br/>
        Hasło: <br/><input type="password" name="haslo"><br/><br/>
        <input type="submit" value="Zaloguj się"/>    
    </form>

    <a href="rejestracja.php">Nie masz konta? Zarejestruj się!</a>
    <br  /><br/>

<?php
   if (isset($_SESSION['blad']))
		echo $_SESSION['blad'];
?>

</body>

</html>