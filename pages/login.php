<section id="login">
	<h2>Logowanie</h2>
<?php
$output_msg = '';
$log = false;
if(!$currUser->isLoggedIn()) :
    if(isset($_POST["login"]) && $_POST["login"] !='' && isset($_POST['password']) && $_POST['password'] != '') {
        $login = $_POST["login"];
        $password = md5($_POST['password']);
        $user = checkUserPassword($login, $password); //sprawdza poprawność hasła

        if($user) { //zalogowano
            $_SESSION['user_id'] = getUserID($login); //zapisanie id usera
            $_SESSION['login'] = true;
            $currUser = new CurrentUser();
            $output_msg .= 'Zalogowano pomyślnie';
            $log = true;
        }
        else
            $output_msg .= 'Login i/lub hasło jest niepoprawne';
    }
    if(!$log) :
?>
<form id="loginform" class="login_body" action="<?php echo URL . '/index.php?page=login' ?>" method="post">
    <fieldset>
        <label for="login">Przykładowe konto - login: test, hasło: test</label>
        <div class="form-group">
            <input class="form-control" placeholder="Login" name="login" type="text" autofocus>
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Hasło" name="password" type="password" value="">
        </div>
        
        <button id="dddd" class="btn btn-lg btn-success btn-block">Zaloguj się</button>
        <br>
        <a href="<?php echo URL . '/index.php?page=reset_password'; ?>">Nie pamiętam hasła!</a>
    </fieldset>
</form>

<?php endif; 
else : ?>
    <div id="msg_form">Jesteś zalogowany jako <?php echo $currUser->getUser()->getName(); ?>. <a href="<?php echo URL; ?>/index.php?page=logout">Wyloguj się</a></div>
<?php endif; ?>
    <div id="msg_form"><?php echo $output_msg; ?> </div>
</section>
