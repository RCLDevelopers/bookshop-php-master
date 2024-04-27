<div class="col-lg-12">
    <h2 class="page-header">Nowa recenzja</h2>
</div>
<?php 
$output_msg = '';
$addReview = false;
$book_id = (isset($_GET['book_id'])) ? $_GET['book_id'] : '0';
if($currUser->isLoggedIn()) : //aby dodać recenzje dany użytkownik musi być zalogowany
    if(!checkUserReview($currUser->getUser()->id_czytelnik, $book_id)) : //sprawdza czy czytelnik dodał już recenzje do danej książki

?>

<?php

$title = (isset($_POST['title'])) ? $_POST['title'] : '';
$text = (isset($_POST['text'])) ? $_POST['text'] : '';
$bookID = (isset($_POST['book'])) ? $_POST['book'] : $book_id;
$rating = (isset($_POST['rating'])) ? $_POST['rating'] : 0;

if($title != '' && $text != '') {

    try {
        // check rating
        $rating = (int) $rating;
        if(!($rating > 0 && $rating <= 10))
            throw new Exception('Ocena powinna zawierać się w przedziale od 1 do 10');

        // check if book exist
        if(!getBook($bookID))
            throw new Exception('Książka nie istnieje');
        
        if(checkUserReview($currUser->getUser()->id_czytelnik, $bookID))
            throw new Exception('Posiadasz już recenzje do tej książki. <a href="' . URL . '/index.php?page=edit_review&book_id= ' . $bookID . '">Edytuj ją</a>');

        $currDate = date("Y-m-d H:i:s");

        $cols = array(
            'id_ksiazka' => $bookID,
            'id_czytelnik' => $currUser->getUser()->id_czytelnik,
            'tytul' => $title,
            'tresc' => $text,
            'ocena' => $rating,
            'data_dodania' => $currDate
        );
        $reviewID = addReview($cols); //dodanie recenzji
        if(!$reviewID)
            throw new Exception('Nie można dodać recenzji do bazy');

        $addReview = true;
        $output_msg .= 'Dodano recenzję. <a href="' . URL . '/index.php?page=review&id= ' . $reviewID . '">' . $title . '</a>';
        echo '<div id="msg_form">' . $output_msg . '</div>';
    } catch (Exception $e) {
        $output_msg .= $e->getMessage();
    }
   
}
?>
<?php
if(!$addReview) :
    $output_msg .= '<br> *Wypełnij wymagane pola';
?>
<div id="msg_form"><?php echo $output_msg; ?> </div>
<form id="add_book_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <div class="col-lg-7">
        <div class="panel panel-default">
			<div class="panel-heading">Wypełnij pola</div>
            <div class="panel-body">
                <label for="title">Tytuł recenzji*:</label>
                <div class="form-group">
                    <input class="form-control" placeholder="" name="title" id="title" type="text" value="<?php echo $title; ?>">
                </div>
                <label for="text">Treść recenzji*:</label>
                <div class="form-group">
                    <textarea class="form-control" rows="15" name="text" id="text"><?php echo $text; ?></textarea>
                </div>

                <button class="btn btn-lg btn-success btn-block">Dodaj</button>
        
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
            <div class="panel-heading">Wybierz książkę*</div>
            <div class="panel-body">
                <div class="list_option">

<?php
$books = selectBook();
if($books) {
	foreach($books as $book) {
        $checked = '';
        if($book->id_ksiazka == $book_id)
            $checked = 'checked';
		echo "<label><input name='book' value='" . $book->id_ksiazka . "' type='radio' " . $checked . " > " . $book->tytul . "</label>";
	}
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
    else : //czytelnik dodał już recenzje do danej książki
        echo '<div id="msg_form">Twoja recenzja do tej książki już istnieje. <a href="' . URL . '/index.php?page=edit_review&book_id= ' . $book_id . '">Edytuj ją</a></div>';
    endif;
else : //użytkownik nie jest zalogowany
    echo '<div id="msg_form">Aby dodać recenzje musisz się zalogować. <a href="' . URL . '/index.php?page=login">Zaloguj się</a></div>';
endif;
?>



