<?php 

function selectBook($cols = array(), $order = '') {
    $db = Database::getInstance();
    $where = '';
	$orderby = '';
    $args = prepareWhere($cols); //przygotowanie klauzuli WHERE
    if(!empty($args))
        $where .= 'WHERE ' . $args;
    if($order != '')
        $orderby = 'ORDER BY ' . $order;
    $book = $db->select("SELECT * FROM ksiazka " . $where . " " . $orderby . "", 'Book');
    return (isset($book[0])) ? $book : false;
}

function addBook($cols) { //nowa ksiazka
    $db = Database::getInstance();
    $newBook = false;

    if($cols['tytul'] != '' &&  $cols['id_wydawnictwo'] != '' && $cols['cena'] != '') {
        $value = prepareInsert($cols); //przygotowanie kolumn i ich wartości
        $newBook = $db->insert("INSERT INTO ksiazka " . $value . "");
    }

    return ($newBook) ? $db->insertID : false; //zwraca nowe ID z bazy
}

function getBookByCategory($ID, $order = 'k.id_ksiazka DESC') {
    $db = Database::getInstance();
    $args = prepareWhere(array('ka.id_kategoria' => $ID));
    $where = 'WHERE ' . $args;
    $orderby = 'ORDER BY ' . addslashes($order);
    $sql = "SELECT k.* FROM ksiazka AS k
    INNER JOIN ksiazka_kategoria AS kk ON k.id_ksiazka = kk.id_ksiazka 	
    INNER JOIN kategoria AS ka ON kk.id_kategoria = ka.id_kategoria " . $where . " " . $orderby;

    $book = $db->select($sql, 'Book');
    return (isset($book[0])) ? $book : false;
}

function getBookByAuthor($ID, $order = 'k.id_ksiazka DESC') {
    $db = Database::getInstance();
    $args = prepareWhere(array('a.id_autor' => $ID));
    $where = 'WHERE ' . $args;
    $orderby = 'ORDER BY ' . addslashes($order);
    $sql = "SELECT k.* FROM ksiazka AS k
    INNER JOIN ksiazka_autor AS ka ON k.id_ksiazka = ka.id_ksiazka 	
    INNER JOIN autor AS a ON ka.id_autor = a.id_autor " . $where . " " . $orderby;

    $book = $db->select($sql, 'Book');
    return (isset($book[0])) ? $book : false;
}

function getBookByOrder($orderID, $order = 'k.id_ksiazka DESC') {
    $db = Database::getInstance();
    $args = prepareWhere(array('z.id_zamowienie' => $orderID));
    $where = 'WHERE ' . $args;
    $orderby = 'ORDER BY ' . addslashes($order);
    $sql = "SELECT k.* FROM ksiazka AS k
    INNER JOIN zamowienie_ksiazka AS zk ON k.id_ksiazka = zk.id_ksiazka 	
    INNER JOIN zamowienie AS z ON zk.id_zamowienie = z.id_zamowienie " . $where . " " . $orderby;

    $book = $db->select($sql, 'Book');
    return (isset($book[0])) ? $book : false;
}

function getOneBook($cols) {
    $book = selectBook($cols);
    return (isset($book[0])) ? $book[0] : false;
}

function getBookByPublisher($ID) {
    $cols = array('id_wydawnictwo' => $ID);
    return selectBook($cols);
}

function getBook($ID) {
    $cols = array('id_ksiazka' => $ID);
    return getOneBook($cols);
}

function getBookByTitle($title) {
    $cols = array('tytul' => $title);
    return getOneBook($cols);
}

function getBookCategory($ID) {
    $cats = getCategoryByBook($ID);
    $output = '';
    $i = false;
    if($cats) {
        foreach($cats as $cat) {
            if($i)
                $output .= ', ';
            $output .= '<a href="' . URL . '/index.php?page=category&id=' . $cat->id_kategoria . '">' . $cat->nazwa . '</a>';
            $i = true;
        }
    }
    return ($output != '') ? $output : 'brak';
}

function getBookAuthor($ID) {
    $authors = getAuthorByBook($ID);
    $output = '';
    $i = false;
    if($authors) {
        foreach($authors as $author) {
            if($i)
                $output .= ', ';
            $i = true;
            $output .= '<a href="' . URL . '/index.php?page=author&id=' . $author->id_autor . '">' . $author->getName() . '</a>';
           
        }
    }
    return ($output != '') ? $output : 'brak';
}

function getBookPublisher($ID) {
    $pub = getPublisher($ID);
    $output =  '<a href="' . URL . '/index.php?page=publisher&id=' . $pub->id_wydawnictwo . '">' . $pub->nazwa . '</a>';
    return $output;
}

function getBookRating($ID) {
    $cols = array('id_ksiazka' => $ID);
    $reviews = selectReview($cols);
    $average = 0;
    if($reviews) {
        $sum = 0.00;
        foreach($reviews as $review)
            $sum += $review->ocena;
        
        $count = count($reviews);
        $average = $sum / $count;
    }
    return $average;
}

function showBookRating($ID) {
    $rating = getBookRating($ID);
    if($rating != 0) 
        $output = number_format($rating, 1, ',', ' ') . '/10';
    else
        $output = 'brak ocen';

    return $output;
}