<section id="login">
	<h2>Zmiana hasła</h2>
<?php
$output_msg = '';
$reset = false;
?>

<?php 
if(isset($_GET['hash']) && isset($_GET['id']) && isset($_POST['password1']) && isset($_POST['password2'])) { //przygotowanie do zmiany hasła
    $user = getUser($_GET['id']);
    $hash = $_GET['hash'];
    if($user) {
        $password = getUserPassword($user->id_czytelnik);
        $checkHash = md5($user->id_czytelnik.$user->login.$user->email.$password); 

        if($checkHash == $hash) { //hask poprawny, można zmienić hasło
            $pass1 = (isset($_POST['password1'])) ? $_POST['password1'] : '';
            $pass2 = (isset($_POST['password2'])) ? $_POST['password2'] : '';
            if(strlen($pass1) < 8)
                $output_msg .= 'Hasło powinno mieć minimum 8 znaków';
            else if($pass1 != $pass2) {
                $output_msg .= 'Hasła się różnią';
            }
            else { //zmiana hasła
                $password = md5($pass1);
                $reset = resetPassword($user->id_czytelnik, $password);
                if($reset)
                    $output_msg = 'Hasło zostało zmienione. <a href="' . URL . '/index.php?page=login">Zaloguj się</a>';
                else
                    $output_msg .= 'Hasło nie zostało zmienione';
            } 
        }
        else {
             $output_msg = 'Niepoprawny hash';
        }

    }

}

if(isset($_GET['hash']) && isset($_GET['id']) && $reset === false) : //formularz do zmiany hasła
?>

<form id="loginform" class="login_body" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <fieldset>
        <div class="form-group">
            <label for="login">Nowe hasło</label>
            <input class="form-control" placeholder="Hasło" name="password1" type="password" autofocus>
        </div>
        <div class="form-group">
            <label for="login">Powtórz hasło</label>
            <input class="form-control" placeholder="Powtórz hasło" name="password2" type="password">
        </div>
        <button class="btn btn-lg btn-warning btn-block">Wyślij</button>
    </fieldset>
</form>

<?php
elseif(isset($_POST['email']) && $_POST['email'] != '') : //stworzenie linku do zmiany hasła (wysłanie na email)
    $user = getUserByEmail($_POST['email']);
    $password = getUserPassword($user->id_czytelnik);
    $hash = md5($user->id_czytelnik.$user->login.$user->email.$password); 
    $output_msg = 'Wiadomość została wysłana na podany email. Kliknij w link aby zresetować hasło. 
         <a href="' . URL . '/index.php?page=reset_password&id=' . $user->id_czytelnik . '&hash=' . $hash . '">Zresetuj hasło</a>';

elseif($reset === false) : //wprowadzenie emaila

?>
<form id="loginform" class="login_body" action="<?php echo URL . '/index.php?page=reset_password' ?>" method="post">
    <fieldset>
        <div class="form-group">
            <label for="login">Podaj email</label>
            <input class="form-control" placeholder="Email" name="email" type="text" autofocus>
        </div>
        <button class="btn btn-lg btn-warning btn-block">Wyślij</button>
    </fieldset>
</form>

<?php
endif;
?>
    <div id="msg_form"><?php echo $output_msg; ?> </div>
</section>