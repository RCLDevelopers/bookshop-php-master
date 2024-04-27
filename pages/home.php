<section id="book_list">
	<h2>Lista książek</h2>
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
    <div class="book_reviews">
        <h3>Recenzje</h3>    
<?php 

$reviews = selectReview();

if($reviews) :
	foreach($reviews as $review) : ?>
        <div class="review">
            <div class="title">
                <a href="<?php echo URL . '/index.php?page=review&id=' .$review->id_recenzja ?>"><?php echo $review->tytul; ?></a>
            </div>
        </div>
<?php
	endforeach;
endif;
?>
    </div>
</section>