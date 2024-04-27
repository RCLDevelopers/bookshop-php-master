<section id="signup">
	<h2>Załóż nowe konto</h2>
<?php
$output_msg = '';
$reg = false;
if(!$currUser->isLoggedIn()) :
    $login = (isset($_POST['login'])) ? $_POST['login'] : '';
    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $pass1 = (isset($_POST['password1'])) ? $_POST['password1'] : '';
    $pass2 = (isset($_POST['password2'])) ? $_POST['password2'] : '';

    if($login == '' || $email == '' || $pass1 == '' || $pass2 == '')
        $output_msg .= 'Wypełnij wszystkie pola';
    else if(strlen($pass1) < 8)
        $output_msg .= 'Hasło powinno mieć minimum 8 znaków';
    else if($pass1 != $pass2) {
       $output_msg .= 'Hasła się różnią';
    }
    else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $output_msg .= 'Adres e-mail nie jest poprawny';
    }
    else if(userExist($login) === true) {
        $output_msg .= 'Podany login jest zajęty';
    }
    else if(emailExist($email) === true) {
        $output_msg .= 'Podany e-mail jest zajęty';
    }
    else { //dodanie użytkownika
        $password = md5($pass1);
        if(addUser($login, $password, $email)) {
            $output_msg .= 'Konto zostało utworzone. <a href="' . URL . '/index.php?page=login">Zaloguj się</a>';
            $reg = true;
        }
        else 
            $output_msg .= 'Konto nie zostało utworzone';
    }

    if(!$reg) :
?>
<form id="signupform" class="signup_body" action="<?php echo URL . '/index.php?page=signup' ?>" method="post">
    <label for="login">Login</label>
    <div class="form-group">
        <input class="form-control" placeholder="Wpisz login" name="login" type="text" value="<?php echo $login; ?>">
    </div>
    <label for="email">E-mail</label>
    <div class="form-group">
        <input class="form-control" placeholder="Wpisz e-mail" name="email" type="text" value="<?php echo $email; ?>">
    </div>
    <label for="email">Hasło</label>
    <div class="form-group">
        <input class="form-control" placeholder="Podaj hasło" name="password1" type="password" value="">
    </div>
    <label for="email">Powtórz hasło</label>
    <div class="form-group">
        <input class="form-control" placeholder="Powtórz hasło" name="password2" type="password" value="">
    </div>
    <br>
    <button id="dddd" class="btn btn-lg btn-success btn-block">Wyślij</button>
</form>

<?php endif; else : ?>
    <div id="msg_form">Jesteś zalogowany jako <?php echo $currUser->getUser()->getName(); ?>. <a href="<?php echo URL; ?>/index.php?page=logout">Wyloguj się</a></div>
<?php endif; ?>
    <div id="msg_form"><?php echo $output_msg; ?> </div>
</section>
