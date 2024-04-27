<section id="book_list">
	<h2>Lista książek</h2>
	<h5><a href="<?php echo URL . "/index.php?page=admin&action=add_book" ; ?>">Dodaj nową</a></h5>
	<div class="book_list_body">
<?php 

$books = selectBook();

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