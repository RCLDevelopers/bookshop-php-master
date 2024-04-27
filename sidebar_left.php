            
			<div id="sidebar-left" class="sidenav">
			    <p><a href="<?php echo URL . '/index.php?page=admin&action=add_book'; ?>">Dodaj książkę</a></p>
			   	<p><a href="<?php echo URL . '/index.php?page=add_review'; ?>">Dodaj recenzję</a></p>
<?php if($currUser->isLoggedIn()) : ?>
<p><a href="<?php echo URL . '/index.php?page=user&id=' .$currUser->getUser()->id_czytelnik; ?>">Twoje recenzje</a></p>
<?php endif; ?>
			</div>
			<div id="main">	