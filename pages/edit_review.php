<?php
$book_id = (isset($_GET['book_id'])) ? $_GET['book_id'] : '0';
$review_id = (isset($_GET['id'])) ? $_GET['id'] : '0';
if($currUser->isLoggedIn()) : //aby edytować recenzje dany użytkownik musi być zalogowany
    if($book_id != '0')
        $review = getUserReview($currUser->getUser()->id_czytelnik, $book_id);
    else
        $review = getReview($review_id);
    if($review && isReviewAuthor($currUser->getUser()->id_czytelnik, $review->id_recenzja)) :

?>
<div class="col-lg-12">
    <h2 class="page-header">Edytuj recenzję: <?php echo $review->tytul; ?></h2>
</div>
<?php 
$output_msg = '';
$editReview = false;

$edit = (isset($_POST['edit'])) ? $_POST['edit'] : '';
$text = (isset($_POST['text'])) ? $_POST['text'] : $review->tresc;
$rating = (isset($_POST['rating'])) ? $_POST['rating'] : $review->ocena;

if($edit != '' && $text != '') {

    try {
        // check rating
        $rating = (int) $rating;
        if(!($rating > 0 && $rating <= 10))
            throw new Exception('Ocena powinna zawierać się w przedziale od 1 do 10');

        $colsUpdate = array('tresc' => $text, 'ocena' => $rating);
        $colsWhere = array('id_recenzja' => $review->id_recenzja, 'id_czytelnik' => $currUser->getUser()->id_czytelnik);
        $editReview = updateReview($colsUpdate, $colsWhere); //edycja recenzji

        if(!$editReview)
            throw new Exception('Nie można edytować recenzji');

        $output_msg .= 'Edytowano recenzję. <a href="' . URL . '/index.php?page=review&id= ' . $review->id_recenzja . '">' . $review->tytul . '</a>';
        echo '<div id="msg_form">' . $output_msg . '</div>';
    } catch (Exception $e) {
        $output_msg .= $e->getMessage();
    }
   
}
?>
<?php
if(!$editReview) :
    $output_msg .= '<br> *Wypełnij wymagane pola';
?>
<div id="msg_form"><?php echo $output_msg; ?> </div>
<form id="add_book_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <div class="col-lg-7">
        <div class="panel panel-default">
			<div class="panel-heading">Wypełnij pola</div>
            <div class="panel-body">
                <label for="title">Tytuł recenzji:</label>
                <div class="form-group">
                    <input class="form-control" placeholder="" name="title" id="title" type="text"  disabled value="<?php echo $review->tytul; ?>">
                </div>
                <label for="text">Treść recenzji*:</label>
                <div class="form-group">
                    <textarea class="form-control" rows="15" name="text" id="text"><?php echo $review->tresc; ?></textarea>
                </div>
                <input name="edit" id="edit" type="hidden" value="edit">
                <button class="btn btn-lg btn-success btn-block">Edytuj</button>
        
	        </div>
        </div>
    </div>
    <div class="col-lg-5">
	    <div class="panel panel-default"> <!-- okładka -->
            <div class="panel-heading">Ocena książki*</div>
            <div class="panel-body">
                <div class="form-group">
                    <select class="form-control" id="rating" name="rating">
                        <option></option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                </div>
	        </div>
        </div>
        <div class="panel panel-default"> <!-- wydawnictwo -->
            <div class="panel-heading">Książka</div>
            <div class="panel-body">
                <div class="list_option">

<?php
$book = getBook($review->id_ksiazka);
if($book) {
    $checked = 'checked';
	echo "<label><input name='book' disabled value='" . $book->id_ksiazka . "' type='radio' " . $checked . " > " . $book->tytul . "</label>";	
}
?>
                    
                </div>
	        </div>
        </div>

    </div>	
</form>
<?php
endif;
?>

<?php
    else : //brak uprawnien do edytowania
        echo '<div id="msg_form">Nie możesz edytować tej recenzji</div>';
    endif;
else : //użytkownik nie jest zalogowany
    echo '<div id="msg_form">Aby edytować recenzje musisz się zalogować. <a href="' . URL . '/index.php?page=login">Zaloguj się</a></div>';
endif;
?>



