         
</div>
<div id="sidebar-right" class="sidenav">
<?php if($currUser->isLoggedIn()) : ?>
<br /> Zalogowany jako <?php echo $currUser->getUser()->getName(); ?>
 <a href="<?php echo URL; ?>/index.php?page=logout">Wyloguj się</a>
<?php else : ?>
<a href="<?php echo URL; ?>/index.php?page=signup">Załóż konto</a>
<?php endif; ?>


</div>