<div class="col-lg-12">
    <h2 class="page-header">Nowa książka</h2>
</div>
<?php

$output_msg = '';

$title = (isset($_POST['title'])) ? $_POST['title'] : '';
$desc = (isset($_POST['desc'])) ? $_POST['desc'] : '';
$isbn = (isset($_POST['isbn'])) ? $_POST['isbn'] : '';
$pages = (isset($_POST['pages'])) ? $_POST['pages'] : '';
$year = (isset($_POST['year'])) ? $_POST['year'] : '';
$lang = (isset($_POST['lang'])) ? $_POST['lang'] : '';
$price = (isset($_POST['price'])) ? $_POST['price'] : '';
$count = (isset($_POST['count'])) ? $_POST['count'] : 0;
$img = (isset($_POST['img'])) ? $_POST['img'] : '';
$authors = (isset($_POST['author'])) ? $_POST['author'] : array();
$cats = (isset($_POST['cat'])) ? $_POST['cat'] : array();
$pub = (isset($_POST['pub'])) ? $_POST['pub'] : '';

if($title != '' && $pub != '' && $price != '') :

    try {
        $price = str_replace(array("zł", "zl"), "", $price);
        $price = str_replace(",", ".", $price);
        $price = trim($price);
        if (!preg_match('/^([1-9][0-9]*|0)(\.[0-9]{2})?$/', $price))
            throw new Exception('Cena jest nieprawidłowa');

        //add authors
        $autorIDs = array();
        foreach($authors as $author) {
            if(substr($author, 0, 4) == 'new:') { // sprawdza czy ma dodać nowego autora do bazy
                $author = str_replace("new:", "", $author);
                $info = explode(",", $author);
                $name = $info[0];
                $lastname = $info[1];
                
                if($newAuthor = getAuthorByName($name, $lastname)) // czy autor istnieje w bazie
                    $autorIDs[] = $newAuthor->id_autor;
                else {
                    if($newAuthorID = addAuthor($name, $lastname)) // dodaje autora do bazy
                        $autorIDs[] = $newAuthorID;
                    else
                        throw new Exception('Nie dodano nowego autora');
                }
            }
            else {
                if($checkAuthor = getAuthor($author))
                    $autorIDs[] = $checkAuthor->id_autor;
                else
                    throw new Exception('Nie znaleziono autora o podanym ID');
            }
        } // add authors

        //add category
        $catIDs = array();
        foreach($cats as $cat) {
            if(substr($cat, 0, 4) == 'new:') { // sprawdza czy ma dodać nowa kategorie
                $name = str_replace("new:", "", $cat);
          
                if($newCat = getCategoryByName($name)) // czy kategoria istnieje w bazie
                    $catIDs[] = $newCat->id_kategoria;
                else {
                    if($newCatID = addCategory($name)) // dodaje kategorie do bazy
                        $catIDs[] = $newCatID;
                    else
                        throw new Exception('Nie dodano nowej kategorii');
                }
            }
            else {
                if($checkCat = getCategory($cat))
                    $catIDs[] = $checkCat->id_kategoria;
                else
                    throw new Exception('Nie znaleziono kategorii o podanym ID');
            }
        } // add category

        //add publisher
        $pubID = '';
        if(substr($pub, 0, 4) == 'new:') { // sprawdza czy ma dodać nowe wydawnictwo
            $name = str_replace("new:", "", $pub);

            if($newPub = getPublisherByName($name)) // czy wydawnictwo istnieje w bazie
                $pubID = $newPub->id_wydawnictwo;
            else {
                if($newPubID = addPublisher($name)) // dodaje wydawnictwo do bazy
                    $pubID = $newPubID;
                else
                    throw new Exception('Nie dodano nowego wydawnictwa');
            }
        }
        else {
            if($checkPub = getPublisher($pub))
                $pubID = $checkPub->id_wydawnictwo;
            else
                throw new Exception('Nie znaleziono wydawnictwa o podanym ID');
        } // add publisher

        // add book 
        if(getBookByTitle($title))
            throw new Exception('Książka już istnieje w bazie');
        
        $cols = array(
            'id_wydawnictwo' => $pubID,
            'tytul' => $title,
            'opis' => $desc,
            'ISBN' => $isbn,
            'ilosc_stron' => $pages,
            'rok_wydania' => $year,
            'jezyk_wydania' => $lang,
            'zdjecie_okladki' => $img,
            'cena' => $price,
            'ilosc_sztuk' => $count
        );
        $bookID = addBook($cols);
        if(!$bookID)
            throw new Exception('Nie można dodać książki do bazy');
        
        //add BookAuthor
        foreach($autorIDs as $authorID)
            addBookAuthor($bookID, $authorID);

        //add BookCategory
        foreach($catIDs as $catID)
            addBookCategory($bookID, $catID);
        
        $output_msg = 'Dodano książkę: ' . $title;

    } catch (Exception $e) {
        $output_msg = $e->getMessage();
    }
   


?>
<div id="msg_form"><?php echo $output_msg; ?> </div>
<?php
else :
    $output_msg = '*Wypełnij wymagane pola';
?>
<div id="msg_form"><?php echo $output_msg; ?> </div>
<form id="add_book_form" action="<?php echo URL . '/index.php?page=admin&action=add_book' ?>" method="post">
    <div class="col-lg-7">
        <div class="panel panel-default">
			<div class="panel-heading">Wypełnij pola</div>
            <div class="panel-body">
                <label for="title">Tytuł książki*:</label>
                <div class="form-group">
                    <input class="form-control" placeholder="" name="title" id="title" type="text">
                </div>
                <label for="desc">Opis książki:</label>
                <div class="form-group">
                    <textarea class="form-control" rows="10" name="desc" id="desc"></textarea>
                </div>
               
                <label for="isbn">ISBN:</label>
                <div class="form-group">
                    <input class="form-control" placeholder="" name="isbn" id="isbn" type="text">
                </div>
                <label for="pages">Ilość stron:</label>
                <div class="form-group">
                    <input class="form-control" placeholder="100" name="pages" id="pages" type="text">
                </div>
                <label for="year">Rok wydania:</label>
                <div class="form-group">
                    <input class="form-control" placeholder="2000" name="year" id="year" type="text">
                </div>
                <label for="lang">Język wydania:</label>
                <div class="form-group">
                    <input class="form-control" placeholder="polski" name="lang" id="lang" type="text" value="polski">
                </div>
                
                <label for="price">Cena*:</label>
                <div class="form-group">
                    <input class="form-control" placeholder="0.00" name="price" id="price" type="text" >
                </div>
                <label for="count">Ilość sztuk*:</label>
                <div class="form-group">
                    <input class="form-control" placeholder="1" name="count" id="count" type="text" >
                </div>
                <br>
                <button class="btn btn-lg btn-success btn-block">Dodaj</button>
        
	        </div>
        </div>
    </div>
    <div class="col-lg-5">
	    <div class="panel panel-default"> <!-- okładka -->
            <div class="panel-heading">Okładka</div>
            <div class="panel-body">
                <div class="form-group">
                    <input class="form-control" placeholder="url do zdjęcia" name="img" id="img" type="text">
                </div>
	        </div>
        </div>
        <div class="panel panel-default"> <!-- autor -->
            <div class="panel-heading">Autor</div>
            <div class="panel-body">
                <div class="list_option">

<?php
$authors = selectAuthor();
if($authors) {
	foreach($authors as $author) {
		echo "<label><input name='author[]' value='" . $author->id_autor . "' type='checkbox'> " . $author->getName() . "</label>";
	}
}
?>
                    
                </div>
                <div id="add_new_author_div" class="list_option"></div>
                <div class="input-group">
                    <input type="text" class="form-control" id="add_new_author_name" placeholder="imię">               
                    <input type="text" class="form-control" id="add_new_author_lastname" placeholder="nazwisko (kliknij Dodaj)">       
                    <button id="add_new_author" class="btn btn-default" type="button">Dodaj nowego autora</button>
                </div>

	        </div>
        </div>
       <div class="panel panel-default"> <!-- kategoria -->
            <div class="panel-heading">Kategoria</div>
            <div class="panel-body">
                <div class="list_option">

<?php
$cats = selectCategory();
if($cats) {
	foreach($cats as $cat) {
		echo "<label><input name='cat[]' value='" . $cat->id_kategoria . "' type='checkbox'> " . $cat->nazwa . "</label>";
	}
}
?>
                    
                </div>
                <div id="add_new_cat_div" class="list_option"></div>
                <div class="input-group">
                    <input type="text" class="form-control" id="add_new_cat_name" placeholder="nowa kategoria (kliknij Dodaj)"> 
                    <span class="input-group-btn">
                        <button id="add_new_cat" class="btn btn-default" type="button">Dodaj</button>
                    </span>
                </div>

	        </div>
        </div>
        <div class="panel panel-default"> <!-- wydawnictwo -->
            <div class="panel-heading">Wydawnictwo</div>
            <div class="panel-body">
                <div class="list_option">

<?php
$pubs = selectPublisher();
if($pubs) {
	foreach($pubs as $pub) {
        $checked = '';
        if($pub->nazwa == "inne")
            $checked = 'checked';
		echo "<label><input name='pub' value='" . $pub->id_wydawnictwo . "' type='radio' " . $checked . " > " . $pub->nazwa . "</label>";
	}
}
?>
                    
                </div>
                <div id="add_new_pub_div" class="list_option"></div>
                <div class="input-group">
                    <input type="text" class="form-control" id="add_new_pub_name" placeholder="nowe wydawnictwo (kliknij Dodaj)">   
                    <span class="input-group-btn">
                        <button id="add_new_pub" class="btn btn-default" type="button">Dodaj</button>
                    </span>
                </div>

	        </div>
        </div>

    </div>	
</form>
<?php
endif;
?>



