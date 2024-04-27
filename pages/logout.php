<section id="login">
	<h2>Wyloguj się</h2>
<?php
 $output_msg = '';
if($currUser->isLoggedIn()) {
    $currUser->logOut();
    $currUser = new CurrentUser();
    $output_msg .= 'Zostałeś wylogowany';
}
else {
    $output_msg .= 'Nie jesteś zalogowany. <a href="' . URL . '/index.php?page=login">Zaloguj się</a>';
}
?>
    <div id="msg_form"><?php echo $output_msg; ?> </div>
</section>

