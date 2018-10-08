<?php

	session_start();
	
	if (isset($_SESSION['udanarejestracja']))
	{
		header('Location: index.php');
		exit();
    }
    else{
        unset($_SESSION['udanarejestracja']);
    }

    //usuwamy zmienne do zapamietania wartosci
  
    if (isset($_SESSION['fr_regulamin']))
    unset($_SESSION['fr_regulamin']);
    if (isset($_SESSION['fr_haslo2']))
    unset($_SESSION['fr_haslo2']);
    if (isset($_SESSION['fr_haslo']))
    unset($_SESSION['fr_haslo']);
    if (isset($_SESSION['fr_login']))
    unset($_SESSION['fr_login']);
    if (isset($_SESSION['fr_mail']))
    unset($_SESSION['fr_mail']);
    if (isset($_SESSION['fr_nazwisko']))
    unset($_SESSION['fr_nazwisko']);
    if (isset($_SESSION['fr_Imie']))
    unset($_SESSION['fr_Imie']);
    if (isset($_SESSION['fr_phone']))
    unset($_SESSION['fr_phone']);
    if (isset($_SESSION['fr_phone2']))
    unset($_SESSION['fr_phone2']);
    if (isset($_SESSION['fr_address']))
    unset($_SESSION['fr_address']);
    if (isset($_SESSION['fr_nick']))
    unset($_SESSION['fr_nick']);


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Polanka - Zarządzaj swoim domem jak nigdy dotąd</title>
</head>

<body>

    Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto!    <br  /><br/>


    "Only the stupid need organization,the genius controls the chaos!" - Albert Einstein
    <br  /><br/>

    <a href="index.php">Zaloguj się na swoje konto!</a>
    <br  /><br/>

<?php
   if (isset($_SESSION['blad']))
		echo $_SESSION['blad'];
?>

</body>

</html>