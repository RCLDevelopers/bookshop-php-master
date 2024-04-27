<?php
if(isset($_GET['id']) && ($review = getReview($_GET['id']))) :
    $book = getBook($review->id_ksiazka);
    $user = getUser($review->id_czytelnik);
?>
<section id="book_page">
    <h2><?php echo $review->tytul; ?></h2>
    <div class="book_wrap">
        <div class="description">
            <p>Recenzja książki: <b><a href="<?php echo URL . '/index.php?page=book&id=' .$book->id_ksiazka ?>"><?php echo $book->tytul; ?></a></b>.</p>
            <p>Autor recenzji: <b><?php echo $user->getName(); ?></b></p>
            <p>Ocena: <b><?php echo $review->ocena; ?></b></p>
            <p><?php echo $review->tresc; ?></p>
<?php //jeśli user jest autorem recenzji to może ją edytować
if($currUser->isLoggedIn() && isReviewAuthor($currUser->getUser()->id_czytelnik, $review->id_recenzja)) :
?>   
<p><a href="<?php echo URL . '/index.php?page=edit_review&id=' . $review->id_recenzja . ''; ?>">Edytuj</a></p>
<?php endif; ?>         

        </div>
        <div class="book_right">
            <a href="<?php echo URL . '/index.php?page=book&id=' .$book->id_ksiazka ?>"><img class="cover" alt="okladka" src="<?php echo $book->zdjecie_okladki; ?>" /></a>
            
        </div>
    </div>

</section>



<?php
else:
    header('Location: ' . URL . '/index.php?page=404');
endif;

?>