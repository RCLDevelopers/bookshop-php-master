<?php 

function selectReview($cols = array()) {
    $db = Database::getInstance();
    $where = '';
    $args = prepareWhere($cols); //przygotowanie klauzuli WHERE
    if(!empty($args))
        $where .= 'WHERE ' . $args;
    $review = $db->select("SELECT * FROM recenzja " . $where . "", 'Review');
    return (isset($review[0])) ? $review : false;
}

function addReview($cols) { //nowa recenzja
    $db = Database::getInstance();
    $newReview = false;

    if($cols['tytul'] != '' &&  $cols['id_ksiazka'] != '' && $cols['id_czytelnik'] != '') {
        $value = prepareInsert($cols); //przygotowanie kolumn i ich wartości
        $newReview = $db->insert("INSERT INTO recenzja " . $value . "");
    }

    return ($newReview) ? $db->insertID : false; //zwraca nowe ID z bazy
}

function updateReview($colsUpdate = array(), $colsWhere = array()) {
    $db = Database::getInstance();
    $where = '';
    $set = prepareUpdate($colsUpdate);
    $args = prepareWhere($colsWhere);
    $where .= 'WHERE ' . $args;
    $return = $db->update("UPDATE recenzja SET " . $set . " " . $where . "");
    return $return;
}

function getOneReview($cols) {
    $review = selectReview($cols);
    return (isset($review[0])) ? $review[0] : false;
}

function getReviewByBook($bookID) {
    $cols = array('id_ksiazka' => $bookID);
    return selectReview($cols);
}
function getReview($ID) {
    $cols = array('id_recenzja' => $ID);
    return getOneReview($cols);
}
function getReviewByUser($ID) {
    $cols = array('id_czytelnik' => $ID);
    $reviews = selectReview($cols);
    return (isset($reviews[0])) ? $reviews : false;
}

function checkUserReview($userID, $bookID) { //sprawdza czy czytelnik dodał już recenzje do danej książki
    $review = getUserReview($userID, $bookID);
    return ($review) ? true : false;
}

function getUserReview($userID, $bookID) { //zwraca recenzje czytelnika danej książki
    $cols = array('id_ksiazka' => $bookID, 'id_czytelnik' => $userID);
    return getOneReview($cols);
}

function isReviewAuthor($userID, $reviewID) {
    $cols = array('id_recenzja' => $reviewID, 'id_czytelnik' => $userID);
    $review = getOneReview($cols);
    return ($review) ? true : false;
}