<?php
if(isset($_GET['id']) && ($pub = getPublisher($_GET['id']))) :
?>
<section id="book_list">
	<h2>Wydawnictwo: <?php echo $pub->nazwa; ?></h2>
	<div class="book_list_body">
<?php 

$books = getBookByPublisher($pub->id_wydawnictwo);

if($books) {
	foreach($books as $book) : ?>
		<div class="book">
			<div class="book_wrap">
				<a href="<?php echo URL . "/index.php?page=book&id=" . $book->id_ksiazka; ?>">
				<img class="cover" alt="okladka" src="<?php echo $book->zdjecie_okladki; ?>" />
				<div class="info">
					<div class="title"><?php echo $book->tytul; ?></div>
					<div class="price"><i><?php echo $book->cena; ?> zł</i></div>
				</div>
				</a>
			</div>
		</div>
<?php
	endforeach;
}
?>
	</div>
</section>


<?php
else:
    header('Location: ' . URL . '/index.php?page=404');
endif;
?>