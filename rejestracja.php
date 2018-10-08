<?php

	session_start();
    
    if(isset($_POST['mail']))
    {
        //udana walidacja
        $OK=true;

        //nazwa Domu
        $name = $_POST['name'];

        //length of nick
        if ((strlen($name)<3) || (strlen($name)>20))
        {
            $OK=false;
            $_SESSION['e_nick']="Nazwa domu musi posiadać od 3 do 20 znaków!";
        }

        if(ctype_alnum($name)==false)
        {
            $OK=false;
            $_SESSION['e_nick']="Nazwa domu musi składać się tylko z liter i cyfr (bez polskich znaków!)";
        }

        

        // check Addresss 

        $address = $_POST['address'];

        if ((strlen($address)<3) || (strlen($address)>1000))
        {
            $OK=false;
            $_SESSION['e_address']="Adres musi posiadać od 3 do 1000 znaków!";
        }

        //check number phone
        $phone = $_POST['phone_number'];


        if (strlen($phone)!=9) 
        {
            $OK=false;
            $_SESSION['e_phone']="Numer telefonu musi posiadać 9 cyfr!";
        }

        if(ctype_alnum($phone)==false)
        {
            $OK=false;
            $_SESSION['e_phone']="Numer telefonu musi składać się tylko z liczb!)";
        }

        if(is_numeric($phone)==false)
        {
            $OK=false;
            $_SESSION['e_phone']="Numer telefonu musi składać się tylko z liczb!)";
        }
        //check number phone
        $phone2 = $_POST['phone_number2'];


        if (strlen($phone2)!=9) 
        {
            $OK=false;
            $_SESSION['e_phone2']="Numer telefonu musi posiadać 9 cyfr!";
        }

        if(ctype_alnum($phone2)==false)
        {
            $OK=false;
            $_SESSION['e_phone2']="Numer telefonu musi składać się tylko z liczb!)";
        }

        if(is_numeric($phone2)==false)
        {
            $OK=false;
            $_SESSION['e_phone2']="Numer telefonu musi składać się tylko z liczb!)";
        }


        //Imie
        $Imie = $_POST['Imie'];

        //length of nick
        if ((strlen($Imie)<3) || (strlen($Imie)>20))
        {
            $OK=false;
            $_SESSION['e_Imie']="Imie musi posiadać od 3 do 20 znaków!";
        }

        if(ctype_alpha($Imie)==false)
        {
            $OK=false;
            $_SESSION['e_Imie']="Imie musi składać się tylko z liter!";
        }


        //Imie
        $nazwisko = $_POST['nazwisko'];

        //length of nazwisko
        if ((strlen($nazwisko)<3) || (strlen($nazwisko)>30))
        {
            $OK=false;
            $_SESSION['e_nazwisko']="Nazwisko musi posiadać od 3 do 20 znaków!";
        }

        if(ctype_alpha($nazwisko)==false)
        {
            $OK=false;
            $_SESSION['e_nazwisko']="nazwisko musi zawierać jedynie litery";
        }

        $mail = $_POST['mail'];
        $mailB = filter_var($mail,FILTER_SANITIZE_EMAIL);

        if ((filter_var($mailB,FILTER_VALIDATE_EMAIL)==false) || ($mailB!=$mail))
        {
            $OK=false;
            $_SESSION['e_mail']="Podaj poprawny adres E-mail";
        }



        
        $login = $_POST['Login'];
        $loginB = filter_var($login,FILTER_SANITIZE_EMAIL);


        //length of nick
        if ((filter_var($loginB,FILTER_VALIDATE_EMAIL)==false) || ($loginB!=$login))
        {
            $OK=false;
            $_SESSION['e_mail']="Podaj poprawny adres E-mail";
        }

        //Password

        $haslo1=$_POST['haslo1'];
        $haslo2=$_POST['haslo2'];

        //length of nick
        if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
        {
            $OK=false;
            $_SESSION['e_haslo']="Login musi posiadać od 8 do 20 znaków!";
        }
        
        if($haslo1!=$haslo2)
        {
            $OK=false;
            $_SESSION['e_haslo']="Podane hasła nie są identyczne!";
        }

        $haslo_hash = password_hash($haslo1,PASSWORD_DEFAULT);

        if(!isset($_POST['regulamin']))
        {
            $OK=false;
            $_SESSION['e_regulamin']="Potwierdź akceptacje regulaminu!";
        }

        $secret="6LeQ4XMUAAAAAN1jJX7wNmKYIG-pFQpGY-D1K6wj";

        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);

        $response = json_decode($check);


        if($response->success==false)
        {
            $OK=false;
            $_SESSION['e_captcha']="Potwierdź, że nie jesteś botem!";
        }

        //pamietanie danych
        $_SESSION['fr_nick'] = $name ;
        $_SESSION['fr_address'] = $address ;
        $_SESSION['fr_phone'] = $phone ;
        $_SESSION['fr_phone2'] = $phone2 ;
        $_SESSION['fr_Imie'] = $Imie ;
        $_SESSION['fr_nazwisko'] = $nazwisko ;
        $_SESSION['fr_mail'] = $mail ;
        $_SESSION['fr_login'] = $login ;
        $_SESSION['fr_haslo'] = $haslo1 ;
        $_SESSION['fr_haslo2'] = $haslo2 ;

        if(isset($_POST['regulamin'])) $_SESSION['fr_regulamin']=true;



        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try{

            $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
            if($polaczenie->connect_errno!=0)
            {
              throw new Exception(mysqli_connect_errno());
            }
            else{
                //mail w bazie?
                $result=$polaczenie->query("SELECT id From dormitory WHERE mail='$mail'");

                if(!$result) throw new Exception($polaczenie->error);
                $amount_mails = $result->num_rows;
                if($amount_mails>0)
                {
                    $OK=false;
                    $_SESSION['e_mail']="Istnieje już dom z takim adresem E-mail!";
                }
                //login w bazie?
                $result=$polaczenie->query("SELECT id From users WHERE email='$login'");

                if(!$result) throw new Exception($polaczenie->error);
                $amount_mailsnick = $result->num_rows;
                if($amount_mailsnick>0)
                {
                    $OK=false;
                    $_SESSION['e_login']="Istnieje już konto o takim adresie E-mail!";
                }

                if($OK==true)
                {
                    //add house to data base

                    
                    
                    if($polaczenie->query("INSERT INTO dormitory VALUES (NULL, '$name','$address','$phone','$mail')"))
                    {
                        $dormitory_id=mysqli_query($polaczenie,"SELECT id FROM `dormitory` WHERE name='$name'");
                        $row = $dormitory_id->fetch_assoc();
                    }
                    else{

                        throw new Exception($polaczenie->error);

                        }
                        if($polaczenie->query("INSERT INTO users VALUES (NULL,'$login','$haslo_hash','$row[id]','$Imie','$nazwisko','$phone2',0,0)"))
                        {
                            $_SESSION['udanarejestracja']=true;
                            header('Location: welcome.php');
                        }
                        else{
                            echo("$login,$haslo_hash,$count,$Imie,$nazwisko,$phone2");

                            throw new Exception($polaczenie->error);
    
                            }

                }


                $polaczenie->close();
            }

        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestracje w innym terminie!</span>';
            echo '<br/> Informacja developreska: '.$e;
        }

      

    }

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Polanka - Załóż darmowe konto!</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>

        .error
        {
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>

</head>




<body>

    <form method="post">
    

        Nazwa Domu: <br/> <input type="text" value="<?php
        if(isset($_SESSION['fr_nick']))
        {
            echo($_SESSION['fr_nick']);
            unset($_SESSION['fr_nick']);
        }
        ?>" name="name"/> <br/>

        <?php

            if(isset($_SESSION['e_nick']))
            {
                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                unset($_SESSION['e_nick']);
            }
            

        ?>

        Adres: <br/> <input type="text"
        value="<?php
        if(isset($_SESSION['fr_address']))
        {
            echo($_SESSION['fr_address']);
            unset($_SESSION['fr_address']);
        }
        ?>" name="address"/> <br/>

        <?php

            if(isset($_SESSION['e_address']))
            {
                echo '<div class="error">'.$_SESSION['e_address'].'</div>';
                unset($_SESSION['e_address']);
            }
            

        ?>
        Numer telefonu stacjonarny : <br/> <input type="text" value="<?php
        if(isset($_SESSION['fr_phone']))
        {
            echo($_SESSION['fr_phone']);
            unset($_SESSION['fr_phone']);
        }
        ?>"name="phone_number"/> <br/>
        <?php

            if(isset($_SESSION['e_phone']))
            {
                echo '<div class="error">'.$_SESSION['e_phone'].'</div>';
                unset($_SESSION['e_phone']);
            }
            

        ?>

        Numer telefonu komorkowy : <br/> <input type="text" value="<?php
        if(isset($_SESSION['fr_phone2']))
        {
            echo($_SESSION['fr_phone2']);
            unset($_SESSION['fr_phone2']);
        }
        ?>"name="phone_number2"/> <br/>
        <?php

            if(isset($_SESSION['e_phone2']))
            {
                echo '<div class="error">'.$_SESSION['e_phone2'].'</div>';
                unset($_SESSION['e_phone2']);
            }
            

        ?>

        Imie: <br/> <input type="text" value="<?php
        if(isset($_SESSION['fr_Imie']))
        {
            echo($_SESSION['fr_Imie']);
            unset($_SESSION['fr_Imie']);
        }
        ?>" name="Imie"/> <br/>

        <?php

            if(isset($_SESSION['e_imie']))
            {
                echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
                unset($_SESSION['e_imie']);
            }
            

        ?>

        Nazwisko: <br/> <input type="text" value="<?php
        if(isset($_SESSION['fr_nazwisko']))
        {
            echo($_SESSION['fr_nazwisko']);
            unset($_SESSION['fr_nazwisko']);
        }
        ?>" name="nazwisko"/> <br/>

        <?php

            if(isset($_SESSION['e_Nazwisko']))
            {
                echo '<div class="error">'.$_SESSION['e_Nazwisko'].'</div>';
                unset($_SESSION['e_Nazwisko']);
            }
            

        ?>
        

        E-Mail: <br/> <input type="text" value="<?php
        if(isset($_SESSION['fr_mail']))
        {
            echo($_SESSION['fr_mail']);
            unset($_SESSION['fr_mail']);
        }
        ?>" name="mail"/> <br/>

              <?php

            if(isset($_SESSION['e_mail']))
            {
                echo '<div class="error">'.$_SESSION['e_mail'].'</div>';
                unset($_SESSION['e_mail']);
            }
            

        ?>
        Mail Administratora: <br/> <input type="text" value="<?php
        if(isset($_SESSION['fr_login']))
        {
            echo($_SESSION['fr_login']);
            unset($_SESSION['fr_login']);
        }
        ?>"name="Login"/> <br/>

        <?php

            if(isset($_SESSION['e_login']))
            {
                echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                unset($_SESSION['e_login']);
            }
            

        ?>

        Hasło Administratora: <br/> <input type="password" value="<?php
        if(isset($_SESSION['fr_haslo']))
        {
            echo($_SESSION['fr_haslo']);
            unset($_SESSION['fr_haslo']);
        }
        ?>"name="haslo1"/> <br/>
        <?php

            if(isset($_SESSION['e_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                unset($_SESSION['e_haslo']);
            }
            

        ?>
        Powtórz Hasło Administratora : <br/> <input type="password" value="<?php
        if(isset($_SESSION['fr_haslo2']))
        {
            echo($_SESSION['fr_haslo2']);
            unset($_SESSION['fr_haslo2']);
        }
        ?>"name="haslo2"/> <br/>

        
        <label>
        <input type="checkbox" name="regulamin" <?php 
        if(isset($_SESSION['fr_regulamin'])){
            echo "checked";
            unset($_SESSION['fr_regulamin']);
        }
        
        ?>/> Akceptuje Regulamin
        </label>
        <?php

            if(isset($_SESSION['e_regulamin']))
            {
                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                unset($_SESSION['e_regulamin']);
            }
            

        ?>
        <div class="g-recaptcha" data-sitekey="6LeQ4XMUAAAAAP7udKHb6k0X4dOa3I6c3sIVanNB"></div>
        <?php

            if(isset($_SESSION['e_captcha']))
            {
                echo '<div class="error">'.$_SESSION['e_captcha'].'</div>';
                unset($_SESSION['e_captcha']);
            }
            

        ?>
        <br/>

        <input type="submit" value="Zarejestruj się"/> 
        <a href="index.php">Cofnij</a>
        <br  /><br/>



    </form>

</body>

</html>