<?php
if(isset($_GET['id']) && ($book = getBook($_GET['id']))) :

    if(isset($_POST['count'])) { //dodanie książki do koszyka
        $count = $_POST['count'];
        if(is_numeric($count) && $count > 0 && $book->ilosc_sztuk >= $count ) {
            $currUser->getCart()->addBook($book->id_ksiazka, $count);
            echo '<script> alert("Dodano do koszyka"); </script>';
        }
        else
            echo '<script> alert("Brak tylu książek w magazynie"); </script>';
    }

?>
<section id="book_page">
    <h2><?php echo $book->tytul; ?></h2>
    <div class="book_wrap">
        <div class="description">
            <p><?php echo $book->opis; ?></p>
			<div class="book_tableinfo">
                <h4>Informacje o książce</h4>
				<table>
					<tr>
		  				<td>Kategoria:</td>
		 				<td><?php echo getBookCategory($book->id_ksiazka); ?></td>
					</tr>
					<tr>
		  				<td>Autor:</td>
		 				<td><?php echo getBookAuthor($book->id_ksiazka); ?></td>
					</tr>
					<tr>
		  				<td>Rok wydania:</td>
		 				<td><?php echo $book->rok_wydania; ?></td>
					</tr>
                    <tr>
		  				<td>Ilość stron:</td>
		 				<td><?php echo $book->ilosc_stron; ?></td>
					</tr>
                    <tr>
		  				<td>Język:</td>
		 				<td><?php echo $book->jezyk_wydania; ?></td>
					</tr>
                    <tr>
		  				<td>ISBN:</td>
		 				<td><?php echo $book->ISBN; ?></td>
					</tr>
                    <tr>
		  				<td>Wydawnictwo:</td>
		 				<td><?php echo getBookPublisher($book->id_wydawnictwo); ?></td>
					</tr>
                    <tr>
		  				<td>Ocena:</td>
		 				<td><?php echo showBookRating($book->id_ksiazka); ?></td>
					</tr>
					
				</table>
			</div>
        </div>
        <div class="book_right">
            <img class="cover" alt="okladka" src="<?php echo $book->zdjecie_okladki; ?>" />
            <div class="info">
                <div class="price">Cena: <?php echo number_format($book->cena, 2, ',', ' '); ?> zł</div>
                <?php if($book->ilosc_sztuk > 0) : ?>
                <form class="cart" action="<?php echo URL . '/index.php?page=book&id=' .$book->id_ksiazka ?>" method="post" >
                    <div class="count input-group input-group-sm">
                        <span class="input-group-addon" >Ilość sztuk:</span>
                        <input type="text" class="form-control" name="count" value="1" >
                    </div>
                    <br><button class="btn btn-lg btn-warning">Do koszyka</button>
                </form>
                <?php else : ?>
                <i>Brak książki w magazynie</i>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="book_reviews">
        <h5><a href="<?php echo URL . '/index.php?page=add_review&book_id=' .$book->id_ksiazka ?>">Dodaj recenzję</a></h5>
        <h3>Recenzje</h3>    
<?php 

$reviews = getReviewByBook($book->id_ksiazka);

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



<?php
else:
    header('Location: ' . URL . '/index.php?page=404');
endif;

?>